<?php
 /**
 * Controller Class for beer related operations
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */
class BeerController
{
    /**
     * BeerController constructor.
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
     * Show all the beers currently available
     */
    function beersOnTap(){
        $beer = new Beer();
        $beerList = $beer->listOfBeersOnTap();
        $this->_f3->set('beerList', $beerList);

        $this->_f3->set('content', 'beer_views/beerList.html');
        $template = new Template;
        echo $template->render('main.html');
    }


    /**
     *
     * Take beers on tap or off tap
     * as well as edit or delete
     */
    public function admin(){

        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }

        $beer = new Beer();
        if (empty($this->_f3->get('POST.search'))){
            $beerList = $beer->all();
        }else{
            $beerList = $beer->searchByName($this->_f3->get('POST.search'));
        }

        $this->_f3->set('beerList', $beerList);
        $this->_f3->set('test', $this->_f3->get('POST.search'));

        $currentBeerList = $beer->listOfBeersOnTap();
        $this->_f3->set('currentList', $currentBeerList);


        $this->_f3->set('title', 'Admin');
        $this->_f3->set('content', 'beer_views/beer_admin.html');
        $template = new Template;
        echo $template->render('main.html');
    }


    /**
     * Show info about one beer based on it id
     */
    function singleBeer(){
        $beer = new Beer();
        $beer->getById($this->_f3->get('PARAMS.id'));

        $this->_f3->set('id', $beer->id);
        $this->_f3->set('title', $beer->beer_name);

        $this->_f3->set('beer_name', $beer->beer_name);
        $this->_f3->set('description', $beer->description);
        $this->_f3->set('alc', $beer->abv);

        $this->_f3->set('content', 'beer_views/one_beer.html');
        $template = new Template;
        echo $template->render('main.html');
    }

    /**
     * add or remove a beer from the currently on tap list
     */
    function flipTap(){

        $beer = new Beer();
        $beer->getById($this->_f3->get('PARAMS.id'));

        $beer->flipTap();

        $this->_f3->reroute('/admin/');
    }

    /**
     * Add a new beer to the database
     */
    function addBeer(){
        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }

        $beer = new Beer();
        $breweries = new Brewery();

        $this->_f3->set('breweries', $breweries->all());

        $this->_f3->set('formAction', '/newBeer');

        $beer->beer_name = $this->_f3->get('POST.beer_name');
        $beer->description = $this->_f3->get('POST.description');
        $beer->abv = $this->_f3->get('POST.abv');
        $beer->brewery_id = $this->_f3->get('POST.brewery');

        if ($beer->beer_name != '' || $beer->beer_name != null) {
            $beer->save();
            $this->_f3->reroute('/beer/'. $beer->id);
        }

        $this->_f3->set('content', 'beer_views/beer_form.html');
        $template = new Template;
        echo $template->render('main.html');
    }


    /**
     * Edit a beer in the database
     */
    function editBeer()
    {
        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }

        $beer = new Beer();
        $beer->getById($this->_f3->get('PARAMS.id'));

        $this->_f3->set('formAction', '/edit/'.$beer->id);

        $this->_f3->set('beer', $beer);

        $beer->beer_name = $this->_f3->get('POST.beer_name');
        $beer->description = $this->_f3->get('POST.description');
        $beer->abv = $this->_f3->get('POST.abv');

        $beer->edit($beer->id);

        if ($this->_f3->get('POST')){
            $this->_f3->reroute('/beer/'. $beer->id);
        }

        $this->_f3->set('content', 'beer_views/beer_form.html');
        $template = new Template;
        echo $template->render('main.html');
    }

    /**
     * delete a beer in the database
     */
    function deleteBeer(){
        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }
        $beer = new Beer();
        $beer->getById($this->_f3->get('PARAMS.id'));
        $beer->delete($beer->id);
        $this->_f3->reroute('/admin');
    }
}