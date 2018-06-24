<?php

/**
 * Base Model for other objects in the application
 * contains many basic operations for model objects
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */

abstract class Model extends \DB\SQL\Mapper{
    /**
     * The DB/SQL/Mapper class needs a database and a table to work
     * the model has a database object in it already
     */
    function __construct($table = null){
        $f3 = Base::instance();
        parent::__construct($f3->get('dataBase'), $table);
    }

    /**
     * return an array of all the items in a table
     */
    public function all() {
        $this->load();
        return $this->query;
    }

    /**
     * get an object from a table (if the table has an id)
     */
    public function getById($id) {
        $this->load(array('id=?',$id));
        return $this->query;
    }

    /**
     * get an object back from the Database by field
     */
    public function getByField($field, $param){
        $this->load(array($field.'=?', $param));
        return $this->query[0];
    }

    /**
     * add an item to the table
     */
    public function add() {
        $this->copyFrom('POST');
        $this->save();
    }

    /**
     * update an item in the database
     */
    public function edit($id) {
        $this->load(array('id=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    /**
     * delete an item from a table in the database
     */
    public function delete($id) {
        $this->load(array('id=?',$id));
        $this->erase();
    }
}