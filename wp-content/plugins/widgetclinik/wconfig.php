<?php
// Файл конфигурации
    class widgetclinikConfig {
        // Имя плагина
        public $namePlugin = "widgetclinik";
        // Версмия плагина
        public $version = 1.0;
        // Имя папки плагина
        public $dirPlugin = "widgetclinik";
        // Права тот кто может пользоватся плагином
        public $rights = "8";
        
        
        // Раздел для установки
        public $sql_table_clinik = array();
        
        function widgetclinikConfig(){
            // Инициализация массива с таблицей
            $this->init_sql_table();
        }
        
        // Инициализация массива с таблицей
        function init_sql_table(){
            global $wpdb;
            
            $this->sql_table_clinik["categories"] = array("name" => $wpdb->prefix."wclinik_categories",
                   "sql"=>"CREATE TABLE ".$wpdb->prefix."wclinik_categories (
                   id int NOT NULL AUTO_INCREMENT,
                   parent int NOT NULL,
                   id_1с text NOT NULL,
                   name text NOT NULL,
                   UNIQUE KEY id (id)
                   );");
            
            $this->sql_table_clinik["doctor"] = array("name" => $wpdb->prefix."wclinik_doctor",
                   "sql"=>"CREATE TABLE ".$wpdb->prefix."wclinik_doctor (
                   id int NOT NULL AUTO_INCREMENT,
                   id_1с text NOT NULL,
                   name text NOT NULL,
                   UNIQUE KEY id (id)
                   );");
                        
            $this->sql_table_clinik["service"]= array("name" => $wpdb->prefix."wclinik_service",
                    "sql"=>"CREATE TABLE ".$wpdb->prefix."wclinik_service (
                    id int NOT NULL AUTO_INCREMENT,
                    id_categories int NOT NULL,
                    id_1с text NOT NULL,
                    name text NOT NULL,
                    UNIQUE KEY id (id)
                    );");     

            
            $this->sql_table_clinik["doctor_to_service"] = array("name" => $wpdb->prefix."wclinik_doctor_to_service",
                   "sql"=>"CREATE TABLE ".$wpdb->prefix."wclinik_doctor_to_service (
                   id int NOT NULL AUTO_INCREMENT,
                   id_service int NOT NULL,
                   id_doctor int NOT NULL,
                   UNIQUE KEY id (id)
                   );");
            
        }
        
    }

?>