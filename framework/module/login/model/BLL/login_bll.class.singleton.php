<?php
include(MODEL_PATH . 'middleware_auth.php');

class login_bll
{
    private $dao;
    private $db;
    static $_instance;

    function __construct()
    {
        $this->dao = login_dao::getInstance();
        $this->db = db::getInstance();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get_register_BLL($args)
    {
        $check = login_bll::get_user_repeat_BLL($args[0]);
        if ($check) {
            return $check;
        } else {
            $hashed_pass = password_hash($args[2], PASSWORD_DEFAULT);
            $hashavatar = md5(strtolower(trim($args[1]))); 
            $avatar = "https://placeimg.com/400/400/$hashavatar";
            $email_token = common::generate_Token_secure(20);
            $id_token = common::generate_Token_secure(4);
            $this -> dao -> insert_user($this->db, $args[0], $args[1], $hashed_pass, $avatar, $email_token, $id_token);

            $message = [
                'type' => 'validate',
                'token' => $email_token,
                'toEmail' => 'santimartinezalbert02@gmail.com'
            ];
            $email = json_decode(mail::send_email($message), true);
            return 'ok';
        }
    }

    public function get_recover_BLL($email) {
        $email_token = common::generate_Token_secure(20);
        $message = [ 'type' => 'recover', 
        'token' => $email_token, 
        'toEmail' => 'santimartinezalbert02@gmail.com'];
        $email_sended = json_decode(mail::send_email($message), true);

        $this -> dao -> update_token_email($this->db,$email_token, $email);
        return $this -> dao -> update_desactivate($this->db,$email_token);
    }

    public function get_user_repeat_BLL($usr)
    {
        if ($this->dao->select_user($this->db, $usr)) {
            return 'error';
        } else {
            return null;
        }
    }

    public function get_user_BLL($token)
    {
        $json = tokendecode($token);
        // return $json['username'];
        return $this->dao->select_user($this->db, $json['username']);
    }

    public function get_login_BLL($usr, $pass)
    {
        $json = tokencreate($usr);
        return $json;
        return $this->dao->select_user($this->db, $usr);
    }

    public function get_update_activate_BLL($args)
    {
        return $this->dao->update_activate($this->db, $args[0]);
    }
}
