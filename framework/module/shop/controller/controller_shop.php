<?php
$path = $_SERVER['DOCUMENT_ROOT'] . "/concessionaire/framework/";
include ($path . 'module/shop/model/DAOShop.php');
if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
}
$shop = new DAOShop();

switch ($_GET['op']) {
    case 'list';
        include ('module/shop/view/shop.html');
        break;
    case 'allcars';
        if (empty($_GET['num'])) {
            $num=0;
        } else {
            $num=$_GET['num'];
        }
        $res = $shop -> listCars($num);
        if (!empty($res)) {
            // $tienda=get_object_vars($res);              
            echo json_encode($res);
        }else {
            echo "error";
        }// end_else
        break;

    case 'details';

        try {
            $car = $shop -> detailsCar($_GET['id']);
        } catch (Exception $e) {
            echo json_encode("error");
        }

        try {
            $img = $shop -> allimg($_GET['id']);
        } catch (Exception $e) {
            echo json_encode("error");
        }

        $data = array();
        $data[0] = $car;
        $data[1][] = $img;
        echo json_encode($data);


        break;

    case 'filters';

        try {
            $filt = $shop -> filtcar($_GET['puertas'], $_GET['color']);
            echo json_encode($filt);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;

    case 'filtbrand';
        try {
            $brand = $shop -> onlymarca($_GET['marca']);
            echo json_encode($brand);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;

    case 'filtcategory';
        try {
            $category = $shop -> onlycat($_GET['category']);
            echo json_encode($category);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;

    case 'filttype';
        try {
            $type = $shop -> onlytype($_GET['type']);
            echo json_encode($type);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;

    case 'sumcount'; 
            $shop -> sumcount($_GET['id']);
            echo json_encode("completed");

    break;

    case 'prueba';
        try {
            $ordered = $shop -> orderby($_GET['order'], $_GET['type']);
            echo json_encode($ordered);
        } catch (Exception $e) {
            echo json_encode("error");
        }
    break;

    case 'count';
        try {
            $count = $shop -> countall();
            echo json_encode($count);
        } catch (Exception $e) {
            echo json_encode("error");
        }
    break;

    case 'related';
        try {
            $related = $shop -> related($_GET['brand'], $_GET['id'], $_GET['limit'] = 0);
            echo json_encode($related);
        } catch (Exception $e) {
            echo json_encode("error");
        }
    break;
        
        

    default:
    break;
}