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
            $this->sql_table_clinik["specialty"]= array("name" => "wclinik_specialty",
                    "sql"=>"CREATE TABLE ".$wpdb->prefix."wclinik_specialty (
                    id mediumint(9) NOT NULL AUTO_INCREMENT,
                    name tinytext NOT NULL,
                    UNIQUE KEY id (id)
                  );");
        
            $this->sql_table_clinik["doctor"] = array("name" => "wclinik_doctor",
                   "sql"=>"CREATE TABLE ".$wpdb->prefix."wclinik_doctor (
                   id mediumint(9) NOT NULL AUTO_INCREMENT,
                   name tinytext NOT NULL,
                   id_specialty mediumint NOT NULL,
                   UNIQUE KEY id (id)
                 );");
        }
        
    }

?>