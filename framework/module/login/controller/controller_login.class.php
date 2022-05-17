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

    function register()
    {
        echo json_encode(common::load_model('login_model', 'get_register', [$_POST['username'], $_POST['email'],  $_POST['password']]));
    }

    function login()
    {
        echo json_encode(common::load_model('login_model', 'get_login', [$_POST['username'], $_POST['password']]));
    }

    function update_activate()
    {
        echo json_encode(common::load_model('login_model', 'get_update_activate', [$_POST['token']]));
    }

    function data_user()
    {
        echo json_encode(common::load_model('login_model', 'get_user', [$_POST['token']]));
    }

    function recover()
    {
        echo json_encode(common::load_model('login_model', 'get_recover', [$_POST['email']]));
    }

    function sl_gmail()
    {
        echo json_encode(common::load_model('login_model', 'get_sl_gmail', [$_POST['id'], $_POST['username'], $_POST['avatar']]));
    }

    function sl_github()
    {
        echo json_encode(common::load_model('login_model', 'get_sl_github', [$_POST['id'], $_POST['username'], $_POST['avatar']]));
    }

    function recover_pass()
    {
        echo json_encode(common::load_model('login_model', 'get_recover_pass', [$_POST['token_email'], $_POST['pass']]));
    }

    function logout()
    {
        echo json_encode(common::load_model('login_model', 'logout'));
    }

    function refresh_token()
    {
        echo json_encode(common::load_model('login_model', 'get_refresh_token', $_POST['token']));
    }

    function refresh_cookie()
    {
        echo json_encode(common::load_model('login_model', 'get_refresh_cookie'));
    }

    function controluser()
    {
        echo json_encode(common::load_model('login_model', 'get_controluser', $_POST['token']));
    }

    function actividad()
    {
        echo json_encode(common::load_model('login_model', 'get_actividad'));
    }

    function likeoption()
    {
        echo json_encode(common::load_model('login_model', 'get_likeoption', [$_POST['token'], $_POST['op']]));
    }
}
