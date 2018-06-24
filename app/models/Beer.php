<?php


/**
 * Beer Model ORM
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */
class Beer extends Model {

    /**
     * accesses the beers table in the database
     */
    function __construct()
    {
        parent::__construct('beers');
    }

    /**
     * get the brewery related to the beer
     */
    function getBrewery(){
        $brewery = new Brewery();
        return $brewery->getByField('id',$this->brewery_id);
    }

    /**
     * get the beers on tap ordered by the brewery
     */
    public function listOfBeersOnTap() {
        $this->load(array('onTap=?',1),array('order' => 'brewery_id'));
        return $this->query;
    }

    /**
     * turn beers on or off
     */
    public function flipTap(){
        if ($this->onTap == 0){
            $this->onTap = 1;
        }else{
            $this->onTap = 0;
        }
        $this->update();
    }

    /**
     * search the database by the name of the beer
     */
    public function searchByName($param){
        return $this->find(array('beer_name LIKE ?',  '%'.$param.'%' ));
    }
}