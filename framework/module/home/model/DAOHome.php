<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/concessionaire/framework/';
include ($path . "model/connect.php");

class QuerysHomePage {
    function selectBrand() {
        $sql = "SELECT DISTINCT id, img FROM marcas ORDER BY id";
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

    function selectCategory() {
        $sql = "SELECT DISTINCT id, img FROM categoria ORDER BY id";
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

    function selectTypes() {
        $sql = "SELECT DISTINCT id, img FROM tipo ORDER BY id";
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

    function selectBoolean($select) {
        $conexion = connect::con();
        if ($conexion) {
            return true;
        }else {
            return false;
        }
    }
}