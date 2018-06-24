<?php

/**
 * Controller Class for user related operations
 *
 * PHP Version 5.4
 *
 * @author Jeremy Belt <jbelt@greenriver.edu>
 * @version 1.0
 */
class UserController{
    /**
     * User Controller constructor.
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
     * create a new user
     */
    function signUp(){
        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }

        $newUser = new User();

        //add the fields to the user object to be saved
        $newUser->name = $this->_f3->get('POST.username');
        $newUser->password = Bcrypt::instance()->hash($this->_f3->get('POST.password'));

        //validate and save
        if (strlen($newUser->name) > 4){
            $newUser->save();
            $this->_f3->reroute('/');
        }

        //load html files
        $this->_f3->set('content', './user_views/sign_up.html');
        $template=new Template;
        echo $template->render('main.html');
    }

    /**
     * login an existing user
     */
    function login(){

        $user = new User();

        $name = $this->_f3->get('POST.username');
        $password = $this->_f3->get('POST.password');

        $user = $user->getByField('name', $name);
        $this->_f3->set('status', $name);
        $this->_f3->set('status', $password);
        $this->_f3->set('status', $user->name);

        if (Bcrypt::instance()->verify($password,$user->password)){
            new Session();
            $this->_f3->set('SESSION.logged_in', true);
            $this->_f3->reroute('/admin');
        }


        $this->_f3->set('content', './user_views/login.html');
        $template=new Template;
        echo $template->render('main.html');
    }

    /**
     * log out a signed in user
     */
    function logOut(){

        $this->_f3->set('SESSION.logged_in', false);
        $this->_f3->reroute('/');
    }

    /**
     * list all the users
     */
    function allUsers(){
        if (!$this->_f3->get('SESSION.logged_in')){
            $this->_f3->reroute('/');
        }
        $users = new User();
        $allUsers = $users->all();
        $this->_f3->set('users', $allUsers);


        $this->_f3->set('content', './user_views/user_list.html');
        $template=new Template;
        echo $template->render('main.html');
    }


}