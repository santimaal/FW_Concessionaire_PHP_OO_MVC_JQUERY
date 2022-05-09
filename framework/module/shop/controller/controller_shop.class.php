<?php
class controller_shop
{

    function list()
    {
        // echo json_encode(common::load_model('shop_model', 'get_orderby', ['ASC', 'precio']));
        common::load_view('top_page_shop.html', VIEW_PATH_SHOP . 'shop.html');
    }

    function allcars()
    {
        echo json_encode(common::load_model('shop_model', 'get_list_products', $_GET['num']));
    }

    function filters()
    {
        echo json_encode(common::load_model('shop_model', 'get_list_filters_products', [$_GET['puertas'], $_GET['color'], $_GET['marca']]));
    }

    function pagination()
    {
        echo json_encode(common::load_model('shop_model', 'get_pagination'));
    }

    function pagination_filters()
    {
        echo json_encode(common::load_model('shop_model', 'get_pagination_filters', $_POST['filters']));
    }

    function details()
    {
        echo json_encode(common::load_model('shop_model', 'get_details', $_GET['id']));
    }

    function sum_visit()
    {
        echo json_encode(common::load_model('shop_model', 'sum_visit', $_GET['id']));
    }
    
    function orderby()
    {
        // echo json_encode(common::load_model('shop_model', 'get_orderby', [$_GET['type'], $_GET['order']]));
        echo json_encode($_GET['type']);
        exit;
        // echo json_encode(common::load_model('shop_model', 'get_orderby', ['precio', 'ASC']));

    }

    function load_like()
    {
        echo json_encode(common::load_model('shop_model', 'get_load_like', $_GET['user']));
    }

    function click_like()
    {
        echo json_encode(common::load_model('shop_model', 'get_click_like', [$_GET['id'], $_GET['user']]));
    }

    function insert_cart()
    {
        echo json_encode(common::load_model('shop_model', 'get_insert_cart', [$_POST['user'], $_POST['id']]));
    }
}
