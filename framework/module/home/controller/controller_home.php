<?php
$path = $_SERVER['DOCUMENT_ROOT'] . "/concessionaire/framework/";
include ($path . 'module/home/model/DAOHome.php');
if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
}
$homeQuery = new QuerysHomePage();


switch ($_GET['op']) {
    case 'list';
        include ('module/home/view/homepage.html');
        break;
    case 'homePageSlide';
        $selSlide = $homeQuery -> selectBrand("SELECT matricula, marca, modelo FROM cars ORDER BY cv DESC LIMIT 5");
        if (!empty($selSlide)) {
            $cars=get_object_vars($selSlide);                
            echo json_encode($cars);
        }else {
            echo "error";
        }// end_else
        break;
    case 'homePageCat';
    // echo json_encode("123");
    // exit;

        $selCatBrand = $homeQuery -> selectCategory();

        if (!empty($selCatBrand)) {
            echo json_encode($selCatBrand);
        }else{
            echo "error";
        }// end_else
        break;

case 'homePageBrand';
// echo json_encode("123");
// exit;

    $selCatBrand = $homeQuery -> selectBrand();

    if (!empty($selCatBrand)) {
        echo json_encode($selCatBrand);
    }else{
        echo "error";
    }// end_else
    break;

case 'homePageType';

$types = $homeQuery -> selectTypes();

if (!empty($types)) {
    echo json_encode($types);
}else{
    echo "error";
}// end_else
break;



default;
    include ('view/inc/error404.html');
    break;
}

// end_switch
