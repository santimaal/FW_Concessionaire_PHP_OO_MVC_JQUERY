<?php
$path = $_SERVER['DOCUMENT_ROOT'] . "/concessionaire/framework/";
include ($path . 'module/search/model/DAOSearch.php');
$search = new DAOSearch();

switch ($_GET['op']) {
    case 'list';
        include ('module/search/view/search.html');
        break;
    case 'marcas';
        try {
            $marcas = $search -> marca();
            echo json_encode($marcas);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;
    case 'ciudades';
        try {
            $ciudades = $search -> ciudad();
            echo json_encode($ciudades);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;
    case 'autocomplete';
        try {
            $auto = $search -> autocomplete();
            echo json_encode($auto);
        } catch (Exception $e) {
            echo json_encode("error");
        }
        break;
    
    
        default;
        break;

    }