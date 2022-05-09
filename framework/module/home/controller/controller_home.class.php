<?php
class controller_home
{
    function list()
    {
        common::load_view('top_page_home.html', VIEW_PATH_HOME . 'homepage.html');
    }

    function homePageBrand()
    {
        echo json_encode(common::load_model('home_model', 'get_carousel'));
    }

    function homePageCat()
    {
        echo json_encode(common::load_model('home_model', 'get_categoria'));
    }

    function homePageType()
    {
        echo json_encode(common::load_model('home_model', 'get_types'));
    }

    function load_more()
    {
        echo json_encode(common::load_model('home_model', 'get_load_more'));
    }
}
