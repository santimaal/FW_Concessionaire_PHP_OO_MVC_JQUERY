<?php
require MODEL_PATH. 'db.class.singleton.php';
    class search_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_marcas($db) {
            $sql = "SELECT DISTINCT id FROM marcas ORDER BY id";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_ciudades_m($db, $marcas) {
            $sql = "SELECT DISTINCT city FROM cars WHERE marca='$marcas'";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_ciudades($db) {
            $sql = "SELECT DISTINCT city FROM cars";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_autocomplete($db, $sql) {
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    }
