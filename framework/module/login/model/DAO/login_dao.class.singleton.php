<?php

class login_dao
{
    static $_instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function select_user($db, $usr)
    {
        $sql = "SELECT * FROM `user` WHERE username='" . $usr . "'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_email($db, $email)
    {
        $sql = "SELECT * FROM `user` WHERE email='" . $email . "'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function insert_user($db, $username, $email, $password, $avatar, $email_token, $id_token)
    {
        $sql = "INSERT INTO `user`(`id`, `username`, `email`, `passwd`, `type`, `avatar`, `token_email`) VALUES ('$id_token','$username','$email','$password','client', '$avatar','$email_token')";
        // return $sql;
        return $stmt = $db->ejecutar($sql);
    }
    public function update_activate($db, $token_email)
    {
        $sql = "UPDATE `user` SET `activate`= 'true' WHERE `token_email` = '$token_email'";
        $stmt = $db->ejecutar($sql);
        return "update";
    }

    public function update_desactivate($db, $token_email)
    {
        $sql = "UPDATE `user` SET `activate`= 'false' WHERE `token_email` = '$token_email'";
        $stmt = $db->ejecutar($sql);
        return "update";
    }

    public function update_token_email($db, $token, $email)
    {
        $sql = "UPDATE `user` SET `token_email`= '$token' WHERE `email` = '$email'";
        $stmt = $db->ejecutar($sql);
        return "ok";
    }
    public function insert_gmail($db, $uid, $username, $avatar)
    {
        $sql = "INSERT INTO `user`(`id`, `username`, `type`, `avatar`, `activate`) VALUES ($uid, $username, 'client', '$avatar', 'true')";
        $stmt = $db->ejecutar($sql);
        return "ok";
    }

    public function update_pass($db, $token_email, $pass)
    {
        $sql = "UPDATE `user` SET `passwd`= $pass WHERE `token_email` = '$token_email'";
        $stmt = $db->ejecutar($sql);
        return "update";
    }

    public function update_tk_email($db, $old_tk, $new_tk)
    {
        $sql = "UPDATE `user` SET `token_email`= $new_tk WHERE `token_email` = '$old_tk'";
        $stmt = $db->ejecutar($sql);
        return "update";
    }

    public function select_likes($db, $username)
    {
        $sql = "SELECT * FROM likes l WHERE l.id_usu=(SELECT u.id FROM user u WHERE u.username='" . $username . "');";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function insert_like($db, $username, $id_car)
    {
        $sql = "INSERT INTO `likes`(`id_usu`, `id_car`) VALUES ((SELECT u.id FROM user u WHERE u.username='" . $username . "'),'" . $id_car . "');";
        $stmt = $db->ejecutar($sql);
        return "ok";
    }

    public function delete_like($db, $username, $id_car)
    {
        $sql = "DELETE FROM likes WHERE likes.id_usu=(SELECT u.id FROM user u WHERE u.username='" . $username . "') AND likes.id_car='" . $id_car . "';";
        $stmt = $db->ejecutar($sql);
        return "ok";
    }
}
