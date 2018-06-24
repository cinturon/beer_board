<?php

/**
 * Brewery Model ORM
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */
class Brewery extends Model{
    /**
     * accesses the brewery table in the database
     */
    function __construct(){
        parent::__construct('breweries');
    }

}