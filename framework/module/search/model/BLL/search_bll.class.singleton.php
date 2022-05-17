<?php
class search_bll
{
	private $dao;
	private $db;
	static $_instance;

	function __construct()
	{
		$this->dao = search_dao::getInstance();
		$this->db = db::getInstance();
	}

	public static function getInstance()
	{
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function get_marcas_BLL()
	{
		return $this->dao->select_marcas($this->db);
	}

	public function get_ciudades_BLL($marcas)
	{
		if ($marcas) {
			return $this->dao->select_ciudades_m($this->db, $marcas);
		} else {
			return $this->dao->select_ciudades($this->db);
		}
	}

	public function get_autocomplete_BLL($auto=null, $marca=null, $city=null)
	{
		if ($marca=='null' && $city=='null' && $auto=='null') {
            $sql= "SELECT * FROM cars;";
        } else if ($marca=='null' && $city=='null')  {
            $sql= "SELECT * FROM cars WHERE modelo LIKE '".$auto."%' OR marca LIKE '".$auto."%';";
        } else if ($marca!='null' && $city=='null') {
            $sql= "SELECT * FROM cars WHERE marca='".$marca."' AND (modelo LIKE '".$auto."%' OR marca LIKE '".$auto."%');";
        } else if ($marca!='null' && $city!='null'){
            $sql= "SELECT * FROM cars WHERE marca='".$marca."' AND city='".$city."' AND (modelo LIKE '".$auto."%' OR marca LIKE '".$auto."%');";
        } else {
            $sql= "SELECT * FROM cars WHERE city='".$city."' AND (modelo LIKE '".$auto."%' OR marca LIKE '".$auto."%');";
        }
		return $this->dao->select_autocomplete($this->db, $sql);
	}
}
