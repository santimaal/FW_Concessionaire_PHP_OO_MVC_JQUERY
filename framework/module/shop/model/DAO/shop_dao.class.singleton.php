<?php

class shop_dao
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

    public function select_list_products($db, $args)
    {
        $sql = "SELECT * FROM cars ORDER BY count DESC LIMIT " . $args . ",5";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_list_filters_products($db, $sql)
    {
        // $filters = self::sql_query($query);
        // $sql = "SELECT codigo_producto, nombre, precio, images FROM producto $filters ORDER BY likes DESC LIMIT $total_prod, $items_page ";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_pagination($db)
    {
        $sql = "SELECT COUNT(*) count FROM cars";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_details($db, $id)
    {
        $sql = "SELECT * FROM cars WHERE id = '$id'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_details_img($db, $id)
    {
        $sql = "SELECT img FROM img WHERE id_car=$id";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }


    public function update_visit($db, $id)
    {
        $sql = "UPDATE cars SET count=(count+1) WHERE id=$id";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_load_likes($db, $user)
    {
        $sql = "SELECT codigo_producto FROM `likes` WHERE user='$user'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_orderby($db, $type, $order)
    {
        $sql = "SELECT * FROM cars ORDER BY $type $order;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function select_likes($db, $id, $user)
    {
        $sql = "SELECT user, codigo_producto FROM `likes` WHERE user='$user' AND codigo_producto='$id'";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    public function insert_likes($db, $id, $user)
    {
        $sql = "INSERT INTO likes (user, codigo_producto) VALUES ('$user','$id')";
        $stmt = $db->ejecutar($sql);
        return "like";
    }

    function delete_likes($db, $id, $user)
    {
        $sql = "DELETE FROM `likes` WHERE user='$user' AND codigo_producto='$id'";
        $stmt = $db->ejecutar($sql);
        return "unlike";
    }
    function get_related($db, $brand, $id, $limit)
    {
        $sql = "SELECT * FROM cars WHERE marca LIKE '%" . $brand . "%' AND id<>" . $id . " LIMIT " . $limit . ",3;";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    function get_cat($db, $category)
    {
        $sql = "SELECT * FROM cars WHERE estado='" . $category . "';";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    function get_brand($db, $marca)
    {
        $sql = "SELECT * FROM cars WHERE marca='" . $marca . "';";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

    function get_type($db, $type)
    {
        $sql = "SELECT * FROM cars WHERE tipo='" . $type . "';";
        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);
    }

}
