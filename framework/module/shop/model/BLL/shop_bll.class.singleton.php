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

	public function get_orderby_BLL($args)
	{
		return $this->dao->select_orderby($this->db, $args[1], $args[0]);
	}

	public function get_details_BLL($args)
	{
		$data = array();

		$car = $this->dao->select_details($this->db, $args);
		$img = $this->dao->select_details_img($this->db, $args);
		$data[0] = $car;
		$data[1][] = $img;

		return $data;
	}

	public function sum_visit_BLL($args)
	{
		return $this->dao->update_visit($this->db, $args);
	}

	public function get_related_BLL($brand, $id)
	{
		if ($this->dao->get_related($this->db, $brand, $id, $_GET['limit'] = 0)) {
			return $this->dao->get_related($this->db, $brand, $id, $_GET['limit'] = 0);
		} else {
			return "error";
		}
	}

	public function get_filtbrand_BLL($args)
	{
		return $this->dao->get_brand($this->db, $args);
	}

	public function get_filtcategory_BLL($args)
	{
		return $this->dao->get_cat($this->db, $args);
	}

	public function get_filttype_BLL($args)
	{
		return $this->dao->get_type($this->db, $args);
	}
}
