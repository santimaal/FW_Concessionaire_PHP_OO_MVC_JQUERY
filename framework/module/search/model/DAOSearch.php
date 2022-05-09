<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/concessionaire/framework/';
include ($path . "model/connect.php");

class DAOsearch {
    function marca() {
        $sql = "SELECT DISTINCT id FROM marcas ORDER BY id";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }// end_while
        }// end_if
        return $retrArray;
    }
    function ciudad() {
        if (!empty($_GET['marca'])) {
        $sql = "SELECT DISTINCT city FROM cars WHERE marca='".$_GET['marca']."'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        // die('<script>console.log('.json_encode('2' .$res ) .');</script>');
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }// end_while
        }// end_if
        return $retrArray;
        } else {
            $sql = "SELECT DISTINCT city FROM cars";
            $conexion = connect::con();
            $res = mysqli_query($conexion, $sql);
            connect::close($conexion);
            // die('<script>console.log('.json_encode('2' .$res ) .');</script>');
            $retrArray = array();
            if ($res->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $retrArray[] = $row;
                }// end_while
            }// end_if
            return $retrArray;        
        }
    }

    function autocomplete() {
        if (empty($_GET['marca']) && empty($_GET['city']) && empty($_GET['auto'])) {
            $sql= "SELECT * FROM cars;";
        } else if (empty($_GET['marca']) && empty($_GET['city']))  {
            $sql= "SELECT * FROM cars WHERE modelo LIKE '".$_GET['auto']."%' OR marca LIKE '".$_GET['auto']."%';";
        } else if (!empty($_GET['marca']) && empty($_GET['city'])) {
            $sql= "SELECT * FROM cars WHERE marca='".$_GET['marca']."' AND (modelo LIKE '".$_GET['auto']."%' OR marca LIKE '".$_GET['auto']."%');";
        } else if ($_GET['marca']!=null && $_GET['city']!=null){
            $sql= "SELECT * FROM cars WHERE marca='".$_GET['marca']."' AND city='".$_GET['city']."' AND (modelo LIKE '".$_GET['auto']."%' OR marca LIKE '".$_GET['auto']."%');";
        } else {
            $sql= "SELECT * FROM cars WHERE city='".$_GET['city']."' AND (modelo LIKE '".$_GET['auto']."%' OR marca LIKE '".$_GET['auto']."%');";
        }
        // echo json_encode($sql);
        // exit;
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        // die('<script>console.log('.json_encode('2' .$res ) .');</script>');
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            }// end_while
        }// end_if
        return $retrArray; 
    }
}