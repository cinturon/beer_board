<?php

/**
 * Controller Class for brewery related operations
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */
class BreweryController{
    /**
     * BreweryController constructor.
     * gives access to base object
     */
    function __construct(){
        $this->_f3 = Base::instance();
    }

    /**
     * check if the user is logged in
     */
    function beforeroute(){
        $this->_f3->set('session_Id', $this->_f3->get('SESSION.user_Id'));
    }

    /**
     * add a new brewery
     */
    function addBrewery(){
        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }
        $newBrewery = new Brewery();

        //file upload manager and creates a changes the name to something unique id
        $overwrite = false;
        $logo = Web::instance()->receive(function ($file){
        },$overwrite,function ($fileBaseName){
            return uniqid().strstr($fileBaseName, '.');
        });

        //this catches the unique name and saves it the DB
        $logoKey = array_keys($logo);
        $logoPath = $this->_f3->get('UPLOADS').pathinfo($logoKey['0'], PATHINFO_BASENAME);


        //check if image was entered if not set it to default
        $defaultImage= 'default.png';
        if ($logoPath == 'app/logos/'){
            $newBrewery->logo = $logoPath . $defaultImage;
        }else{
            $newBrewery->logo = $logoPath;
        }

        //add the fields to the user object to be saved
        $newBrewery->brewery_name = $this->_f3->get('POST.brewery_name');
        $newBrewery->location = $this->_f3->get('POST.brewery_location');


        //validate and save
        if (!empty($newBrewery->brewery_name))  {
            $newBrewery->save();
            $this->_f3->reroute('/list');
        }

        //load html files
        $this->_f3->set('content', './brewery_views/brewery_form.html');
        $template=new Template;
        echo $template->render('main.html');
    }
}