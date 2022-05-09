<?php
require MODEL_PATH. 'db.class.singleton.php';
    class home_dao {
        static $_instance;

        private function __construct() {
        }

        public static function getInstance() {
            if(!(self::$_instance instanceof self)){
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function select_data_carousel($db) {
            $sql = "SELECT DISTINCT id, img FROM marcas ORDER BY id";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_data_categoria($db) {
            $sql = "SELECT * FROM `categoria`";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_data_brands($db, $items, $loaded) {
            $sql = "SELECT * FROM `marcas` LIMIT $loaded, $items";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }

        public function select_data_types($db) {
            $sql = "SELECT DISTINCT id, img FROM tipo ORDER BY id";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }


        public function select_load_more($db) {
            $sql = "SELECT COUNT(*) as 'count' FROM `brands`";
            $stmt = $db->ejecutar($sql);
            return $db->listar($stmt);
        }
    }
