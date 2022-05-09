<?php

class controller_login
{
    function viewlog()
    {
        // echo "log";
        // exit;
        common::load_view('top_page_login.html', VIEW_PATH_LOGIN . 'login.html');
    }

    function viewreg()
    {
        common::load_view('top_page_register.html', VIEW_PATH_LOGIN . 'register.html');
    }

    function register() {
        echo json_encode(common::load_model('login_model', 'get_register', [$_POST['username'], $_POST['email'],  $_POST['password']]));
    }

    function login() {
        echo json_encode(common::load_model('login_model', 'get_login', [$_POST['username'], $_POST['password']]));
    }

    function update_activate() {
        echo json_encode(common::load_model('login_model', 'get_update_activate', [$_POST['token']]));
    }
    
    function data_user() {
        echo json_encode(common::load_model('login_model', 'get_user', [$_POST['token']]));
    }

    function recover() {
        echo json_encode(common::load_model('login_model', 'get_recover', [$_POST['email']]));
    }
}
