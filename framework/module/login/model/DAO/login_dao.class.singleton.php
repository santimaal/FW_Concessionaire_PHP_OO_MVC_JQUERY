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
}
