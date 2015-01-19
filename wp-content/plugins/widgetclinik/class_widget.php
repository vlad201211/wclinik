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

    }
?>