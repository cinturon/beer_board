<?php

/**
 * User Model ORM
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */
class User extends Model{
    /**
     * accesses the users table in the database
     */
    function __construct()
    {
        parent::__construct('users');
    }
}