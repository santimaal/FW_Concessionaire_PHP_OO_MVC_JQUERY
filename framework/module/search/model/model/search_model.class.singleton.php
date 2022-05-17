<?php
// require 'paths.php';
// require BLL_SEARCH . 'search_bll.class.singleton.php';

class search_model
{
    private $bll;
    static $_instance;

    function __construct()
    {
        $this->bll = search_bll::getInstance();
    }

    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get_marcas()
    {
        return $this->bll->get_marcas_BLL();
    }

    public function get_ciudades($marcas=null)
    {
        return $this->bll->get_ciudades_BLL($marcas);
    }

    public function get_autocomplete($args)
    {
        return $this->bll->get_autocomplete_BLL($args[0], $args[1], $args[2]);
    }
}
