<?php
include_once 'config.php';
    // Класс управления
    class widgetclinik {
        
        // Параметры
        public $config;
        
        function widgetclinik(){
          
            $this->config = new widgetclinikConfig();
            
        }

        // Добавляем в админку пункт с настройками
        function add_admin_menu(){
            include_once plugin_dir_path( __FILE__ ).'/html/admin_form.php';
            add_menu_page('Виджет dxlab', 'Виджет dxlab', $this->config->rights, basename(__FILE__), 'form_admin_widget');
        }
        
        
        // Установка плагина при активации
        function install () {
            global $wpdb;
            // Имя тестовой таблицы
            $table_name = $wpdb->prefix . "widgetclinik";
            // Проверяем если таблицы реально нет, тогда создаем
            if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

               $sql = "CREATE TABLE " . $table_name . " (
                   id mediumint(9) NOT NULL AUTO_INCREMENT,
                   time bigint(11) DEFAULT '0' NOT NULL,
                   name tinytext NOT NULL,
                   text text NOT NULL,
                   url VARCHAR(55) NOT NULL,
                   UNIQUE KEY id (id)
                 );";

               // Подключаем файл для работы с базой
               require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
               // Выполняем запрос
               dbDelta($sql);

               // Информация для теста
               //$welcome_name = "Mr. Wordpress";
               //$welcome_text = "Поздравляю, установка прошла успешно!";

               // Вносим данные в таблицу
               //$rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );

               // Записываем версию
               add_option("wclinik_db_version", $this->config->version);

            }
         }
        

    }
?>