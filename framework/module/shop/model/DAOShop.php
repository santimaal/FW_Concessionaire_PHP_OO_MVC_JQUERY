<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/concessionaire/framework/';
include($path . "model/connect.php");

class DAOShop
{
    function listCars($numcar = 0)
    {
        $sql = "SELECT * FROM cars ORDER BY count DESC LIMIT " . $numcar . ",5";
        // $sql = "SELECT * FROM cars ORDER BY count DESC";


        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function detailsCar($id)
    {
        $sql = "SELECT * FROM cars WHERE id=$id";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql)->fetch_object();
        connect::close($conexion);
        return $res;
    }

    function allimg($id)
    {
        $sql = "SELECT img FROM img WHERE id_car=$id";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function filtcar($puertas, $color)
    {
        $filters = null;

        if ($color != 'all' && $puertas == 'a') {
            $filters = "";
            $prueba = explode(",", $color);
            for ($i = 0; $i < sizeof($prueba); $i++) {
                if ($i == 0) {
                    $filters .= "(color = '" . $prueba[$i] . "'";
                } else  if ($i == (sizeof($prueba) - 1)) {
                    $filters .= " OR color = '" . $prueba[$i] . "')";
                } else {
                    $filters .= " OR color = '" . $prueba[$i] . "'";
                }
                if (sizeof($prueba) == 1) {
                    $filters .= ")";
                }
            }
        } else if ($color == 'all' && $puertas != 'a') {
            $filters = "puertas=" . $puertas;
        } else {
            $filters = "puertas=" . $puertas . " AND ";

            $prueba = explode(",", $color);
            for ($i = 0; $i < sizeof($prueba); $i++) {
                if ($i == 0) {
                    $filters .= "(color = '" . $prueba[$i] . "'";
                } else  if ($i == (sizeof($prueba) - 1)) {
                    $filters .= " OR color = '" . $prueba[$i] . "')";
                } else {
                    $filters .= " OR color = '" . $prueba[$i] . "'";
                }
                if (sizeof($prueba) == 1) {
                    $filters .= ")";
                }
            }
        }

        if ($puertas == 'a' && $color == 'all' && $_GET['marca'] == 'a') {
            $sql = "SELECT * FROM cars";
        } else if ($puertas == 'a' && $color == 'all' && $_GET['marca'] != 'a') {
            $sql = "SELECT * FROM cars WHERE marca='" . $_GET['marca'] . "';";
        } else if ($puertas != 'a' && $color != 'all' && $_GET['marca'] == 'a') {
            $sql = "SELECT * FROM cars WHERE $filters;";
        } else {
            if ($_GET['marca'] != 'a') {
                $sql = "SELECT * FROM cars WHERE $filters AND marca='" . $_GET['marca'] . "';";
            } else {
                $sql = "SELECT * FROM cars WHERE $filters;";
            }
        }
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);

        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function onlymarca($marca)
    {
        $sql = "SELECT * FROM cars WHERE marca='" . $marca . "';";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function onlycat($category)
    {
        $sql = "SELECT * FROM cars WHERE estado='" . $category . "';";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function onlytype($type)
    {
        $sql = "SELECT * FROM cars WHERE tipo='" . $type . "';";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function sumcount($id)
    {
        $sql = "UPDATE cars SET count=(count+1) WHERE id=$id";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        // return $res;
    }

    function orderby($order, $type)
    {
        $sql = "SELECT * FROM cars ORDER BY $order $type;";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        $retrArray = array();
        if ($res->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $retrArray[] = $row;
            } // end_while
        } // end_if
        return $retrArray;
    }

    function countall()
    {
        $sql = "SELECT COUNT(*) count FROM cars";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql)->fetch_object();
        connect::close($conexion);
        return $res;
    }

    function related($brand, $id, $limit)
    {
        $sql = "SELECT * FROM cars WHERE marca LIKE '%" . $brand . "%' AND id<>" . $id . " LIMIT " . $limit . ",3;";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        if (empty($res)) {
            return null;
        } else {
            $retrArray = array();
            if ($res->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $retrArray[] = $row;
                } // end_while
            } // end_if
            return $retrArray;
        }
    }
}
