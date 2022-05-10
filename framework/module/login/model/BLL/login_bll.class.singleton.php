<?php
include(MODEL_PATH . 'middleware_auth.php');
@session_start();

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
        $check_usr = login_bll::get_user_repeat_BLL($args[0]);
        if (!$check_usr) {
            $check_em = login_bll::get_email_repeat_BLL($args[1]);
        } else {
            return $check_usr;
        }
        if ($check_em) {
            return $check_em;
        } else {
            $hashed_pass = password_hash($args[2], PASSWORD_DEFAULT);
            $hashavatar = md5(strtolower(trim($args[1])));
            $avatar = "https://placeimg.com/400/400/$hashavatar";
            $email_token = common::generate_Token_secure(20);
            $id_token = common::generate_Token_secure(4);
            $this->dao->insert_user($this->db, $args[0], $args[1], $hashed_pass, $avatar, $email_token, $id_token);

            $message = [
                'type' => 'validate',
                'token' => $email_token,
                'toEmail' => 'santimartinezalbert02@gmail.com'
            ];
            $email = json_decode(mail::send_email($message), true);
            return 'ok';
        }
    }

    public function get_recover_BLL($email)
    {
        $email_token = common::generate_Token_secure(20);
        $message = [
            'type' => 'recover',
            'token' => $email_token,
            'toEmail' => 'santimartinezalbert02@gmail.com'
        ];
        $email_sended = json_decode(mail::send_email($message), true);

        $this->dao->update_token_email($this->db, $email_token, $email);
        return $this->dao->update_desactivate($this->db, $email_token);
    }

    public function get_user_repeat_BLL($usr)
    {
        if ($this->dao->select_user($this->db, $usr)) {
            return 'errorusr';
        } else {
            return null;
        }
    }

    public function get_email_repeat_BLL($email)
    {
        if ($this->dao->select_email($this->db, $email)) {
            return 'errorem';
        } else {
            return null;
        }
    }

    public function get_user_BLL($token)
    {
        $json = tokendecode($token);
        return $this->dao->select_user($this->db, $json['username']);
    }

    public function get_login_BLL($usr, $pass)
    {
        $check = login_bll::get_user_repeat_BLL($usr);

        if (!$check) {
            echo json_encode("username");
        } else {
            try {
                $rdo = $this->dao->select_user($this->db, $usr);
                $token = tokencreate($rdo[0]['username']);
                $_SESSION['username'] = $rdo[0]['username'];
                $_SESSION['tiempo'] = time();
            } catch (Exception $e) {
                return "errora";
            }
            if (!$rdo) {
                return "errorb";
            } else {
                if (password_verify($pass, $rdo[0]['passwd'])) {
                    return $token;
                } else {
                    return "error_passwd";
                    exit;
                }
            }
        }
    }

    public function get_update_activate_BLL($args)
    {
        return $this->dao->update_activate($this->db, $args[0]);
    }

    public function get_sl_gmail_BLL($args)
    {
        $uid = "gmail | $args[0]";
        $usr = "gmail | $args[1]";
        $check = login_bll::get_user_repeat_BLL($usr);
        $tokenn = tokencreate($usr);
        $_SESSION['username'] = $usr;
        $_SESSION['tiempo'] = time();
        if ($check) {
            return $tokenn;
        } else {
            $this->dao->insert_gmail($this->db, $uid, $usr, $args[2]);
            return $tokenn;
        }
    }

    public function get_sl_github_BLL($args)
    {
        $uid = "github | $args[0]";
        $usr = "github | $args[1]";
        $check = login_bll::get_user_repeat_BLL($usr);
        $tokenn = tokencreate($usr);
        $_SESSION['username'] = $usr;
        $_SESSION['tiempo'] = time();
        if ($check) {
            return $tokenn;
        } else {
            $uid = "'github | $args[0]'";
            $usr = "'github | $args[1]'";
            $this->dao->insert_gmail($this->db, $uid, $usr, $args[2]);
            return $tokenn;
        }
    }

    public function get_recover_pass_BLL($email_token, $pass)
    {
        $pass_hashed = password_hash($pass, PASSWORD_DEFAULT);
        $this->dao->update_pass($this->db, $email_token, $pass_hashed);
        $old_token = $email_token;
        $new_token = common::generate_Token_secure(20);
        return $this->dao->update_tk_email($this->db, $old_token, $new_token);
    }

    public function get_actividad_BLL()
    {
        if (!isset($_SESSION["tiempo"])) {
            // echo json_encode("tiempo");
            return "tiempo";
        } else {
            if ((time() - $_SESSION["tiempo"]) >= 1800) {
                // echo json_encode("inactivo");
                return "inactivo";
                // exit;
            } else {
                // echo json_encode("activo");
                return "activo";
                // exit;
            }
        }
    }

    public function logout_BLL()
    {
        unset($_SESSION['username']);
        unset($_SESSION['tiempo']);
        session_destroy();
        return "logout";
    }

    public function get_refresh_token_BLL($token)
    {
        $json = tokendecode($_POST['token']);
        $tokenn = tokencreate($json['username']);
        return $tokenn;
    }

    public function get_refresh_cookie_BLL()
    {
        session_regenerate_id();
        return "sessionregenerate";
    }

    public function get_controluser_BLL($token = null)
    {
        if (empty($token)) {
            return "nada";
        } else {
            $json = tokendecode($token);
        }

        if (!isset($_SESSION['username'])) {
            return 'nookay';
        } else {
            if ($_SESSION['username'] == $json['username']) {
                return 'okay';
            } else {
                return 'nookay';
            }
        }
    }
}
