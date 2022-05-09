<?php
require DAO_SHOP . 'shop_dao.class.singleton.php';
require MODEL_PATH . 'db.class.singleton.php';

class shop_bll
{
	private $dao;
	private $db;
	static $_instance;

	function __construct()
	{
		$this->dao = shop_dao::getInstance();
		$this->db = db::getInstance();
	}

	public static function getInstance()
	{
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function get_filters_BLL()
	{
		return $this->dao->select_filters($this->db);
	}

	public function get_list_products_BLL($args)
	{
		return $this->dao->select_list_products($this->db, $args);
	}

	public function get_list_filters_products_BLL($args)
	{

		$puertas = $args[0];
		$color = $args[1];
		$marca = $args[2];

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

		if ($puertas == 'a' && $color == 'all' && $marca == 'a') {
			$sql = "SELECT * FROM cars";
		} else if ($puertas == 'a' && $color == 'all' && $marca != 'a') {
			$sql = "SELECT * FROM cars WHERE marca='" . $marca . "';";
		} else if ($puertas != 'a' && $color != 'all' && $marca == 'a') {
			$sql = "SELECT * FROM cars WHERE $filters;";
		} else {
			if ($marca != 'a') {
				$sql = "SELECT * FROM cars WHERE $filters AND marca='" . $marca . "';";
			} else {
				$sql = "SELECT * FROM cars WHERE $filters;";
			}
		}
		return $this->dao->select_list_filters_products($this->db, $sql);
	}

	public function get_pagination_BLL()
	{
		return $this->dao->select_pagination($this->db);
	}

	public function get_pagination_filters_BLL($args)
	{
		return $this->dao->select_pagination_filters($this->db, json_decode($args));
	}

	public function get_orderby_BLL($args)
	{
		return $this->dao->select_orderby($this->db, $args[1], $args[0]);
	}

	public function get_details_BLL($args)
	{
		$data = array();

		$car = $this -> dao -> select_details($this->db, $args);
		$img = $this -> dao -> select_details_img($this->db, $args);
		$data[0] = $car;
        $data[1][] = $img;

		return $data;
	}

	public function sum_visit_BLL($args)
	{
		return $this->dao->update_visit($this->db, $args);
	}

	public function get_load_like_BLL($args)
	{
		$jwt = jwt_process::decode($args);
		$jwt = json_decode($jwt, TRUE);
		return $this->dao->select_load_likes($this->db, $jwt['name']);
	}

	public function get_click_like_BLL($args)
	{
		$jwt = jwt_process::decode($args[1]);
		$jwt = json_decode($jwt, TRUE);
		if ($this->dao->select_likes($this->db, $args[0], $jwt['name'])) {
			return $this->dao->delete_likes($this->db, $args[0], $jwt['name']);
		}
		return $this->dao->insert_likes($this->db, $args[0], $jwt['name']);
	}
}
