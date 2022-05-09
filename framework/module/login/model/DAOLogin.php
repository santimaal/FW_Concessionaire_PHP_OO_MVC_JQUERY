<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/concessionaire/framework/';
include($path . "model/connect.php");

class DAOLogin
{

    function select_username($username)
    {
        $sql = "SELECT * FROM `user` WHERE username='" . $username . "'";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql)->fetch_object();
        connect::close($conexion);
        return $res;
    }

    function insert_user($username, $email, $password)
    {
        $hashed_pass = password_hash(strval($password), PASSWORD_DEFAULT, ['cost' => 12]);
        $hashavatar = md5(strtolower(trim($email)));
        $avatar = "https://placeimg.com/400/400/$hashavatar";

        $sql = "INSERT INTO `user`(`username`, `email`, `passwd`, `type`, `avatar`)
        VALUES ('$username','$email','$hashed_pass','client', '$avatar')";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function select_user($username)
    {
        $sql = "SELECT * FROM `user` WHERE username='$username'";
        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql)->fetch_object();
        connect::close($conexion);
        $value = get_object_vars($res);
        return $value;
    }

    function like($username, $id_car)
    {
        $sql = "INSERT INTO `likes`(`id_usu`, `id_car`) VALUES ((SELECT u.id FROM user u WHERE u.username='" . $username . "'),'" . $id_car . "');";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function unlike($username, $id_car)
    {
        $sql = "DELETE FROM likes WHERE likes.id_usu=(SELECT u.id FROM user u WHERE u.username='" . $username . "') AND likes.id_car='" . $id_car . "';";

        $conexion = connect::con();
        $res = mysqli_query($conexion, $sql);
        connect::close($conexion);
        return $res;
    }

    function select_like($username)
    {
        $sql = "SELECT * FROM likes l WHERE l.id_usu=(SELECT u.id FROM user u WHERE u.username='" . $username . "');";

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
}
