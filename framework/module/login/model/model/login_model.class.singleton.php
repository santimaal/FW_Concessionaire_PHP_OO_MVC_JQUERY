<?php
class login_model
{
    private $bll;
    static $_instance;

    function __construct()
    {
        $this->bll = login_bll::getInstance();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get_register($args)
    {
        return $this->bll->get_register_BLL($args);
    }
    public function get_update_activate($args)
    {
        return $this->bll->get_update_activate_BLL($args);
    }

    public function get_user($token)
    {
        return $this->bll->get_user_BLL($token[0]);
    }

    public function get_login($args)
    {
        return $this->bll->get_login_BLL($args[0], $args[1]);
    }

    public function get_recover($args)
    {
        return $this->bll->get_recover_BLL($args[0]);
    }

    public function get_sl_gmail($args)
    {
        return $this->bll->get_sl_gmail_BLL($args);
    }

    public function get_recover_pass($args)
    {
        return $this->bll->get_recover_pass_BLL($args[0], $args[1]);
    }

    public function logout()
    {
        return $this->bll->logout_BLL();
    }

    public function get_refresh_token($token)
    {
        return $this->bll->get_refresh_token_BLL($token);
    }

    public function get_refresh_cookie()
    {
        return $this->bll->get_refresh_cookie_BLL();
    }

    public function get_controluser($token)
    {
        return $this->bll->get_controluser_BLL($token);
    }

    public function get_actividad()
    {
        return $this->bll->get_actividad_BLL();
    }
}
