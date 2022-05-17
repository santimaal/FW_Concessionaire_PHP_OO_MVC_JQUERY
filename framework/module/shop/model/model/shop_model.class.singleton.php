<?php

require BLL_SHOP . 'shop_bll.class.singleton.php';

    class shop_model {
        private $bll;
        static $_instance;

        function __construct() {
            $this -> bll = shop_bll::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_list_products($args) {
            return $this -> bll -> get_list_products_BLL($args);
        }

        public function get_list_filters_products($args) {
            return $this -> bll -> get_list_filters_products_BLL($args);
        }

        public function get_pagination() {
            return $this -> bll -> get_pagination_BLL();
        }

        public function get_details($args) {
            return $this -> bll -> get_details_BLL($args);
        }

        public function get_orderby($args) {
            return $this -> bll -> get_orderby_BLL($args);
        }

        public function sum_visit($args) {
            return $this -> bll -> sum_visit_BLL($args);
        }

        public function get_related($args) {
            return $this -> bll -> get_related_BLL($args[0], $args[1]);
        }

        public function get_filtbrand($args) {
            return $this -> bll -> get_filtbrand_BLL($args);
        }

        public function get_filtcategory($args) {
            return $this -> bll -> get_filtcategory_BLL($args);
        }

        public function get_filttype($args) {
            return $this -> bll -> get_filttype_BLL($args);
        }
    }
?>
