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
           // $table_name = $wpdb->prefix . "widgetclinik";
            // Проверяем если таблицы реально нет, тогда создаем
            //if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

               /*$sql = "CREATE TABLE " . $table_name . " (
                   id mediumint(9) NOT NULL AUTO_INCREMENT,
                   time bigint(11) DEFAULT '0' NOT NULL,
                   name tinytext NOT NULL,
                   text text NOT NULL,
                   url VARCHAR(55) NOT NULL,
                   UNIQUE KEY id (id)
                 );";*/

              // Подключаем файл для работы с базой
              require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
              
              // Создаем таблицы
              foreach ($this->config->sql_table_clinik as $key=>$data){
                  // Проверяем если таблицы нет, тогда создаем
                 if($wpdb->get_var("show tables like '".$data['name']."'") != $data['name']) {
                      // Выполняем запрос
                      dbDelta($wpdb->escape($data["sql"])); 
                  }
              }
                
               

               // Информация для теста
               //$welcome_name = "Mr. Wordpress";
               //$welcome_text = "Поздравляю, установка прошла успешно!";

               // Вносим данные в таблицу
               //$rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );

               // Записываем версию
               add_option("wclinik_db_version", $this->config->version);
         }
         
         // Выводим информацию
         function render_html(){
             global $wpdb;
             require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          
             // Выводим список услуг ****************************************************************************************
             $service = $_GET['service'];
             if(empty($_GET['service'])) $service = 0;
             
             $toservice = $_GET['toservice'];
             if(empty($_GET['toservice'])) $toservice = 0;
             
                 $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM ".$this->config->sql_table_clinik["categories"]["name"] )." WHERE parent = ".$toservice);
                 ?>
                 
                <p><a href="?toservice=<?php print $service; ?>">Назад</a></p>
                <ul>
                <?php
                foreach ($rows as $key=>$data){
                ?>
                    <li><a href="?service=<?php print $toservice;?>&toservice=<?php print $data->id;?>">
                    <?php
                        print $data->name;
                    ?>
                    </a></li>
                <?php
                }
                 
                ?>
                </ul>
                
                <?php
                    $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM ".$this->config->sql_table_clinik["service"]["name"] )." WHERE id_categories = ".$toservice);
                    $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM ".$this->config->sql_table_clinik["doctor_to_service"]["name"] )." WHERE id_service = ".$rows[0]->id);
                    
                ?>
                
                <ul>
                <?php
                foreach ($rows as $key=>$data){
                    $data_doctor = $wpdb->get_results($wpdb->escape( "SELECT * FROM ".$this->config->sql_table_clinik["doctor"]["name"] )." WHERE id = ".$data->id_doctor);
                    
                    if(count($data_doctor)==0)continue;
                ?>
                    <li><a href="">
                    <?php
                        print $data_doctor[0]->name;
                    ?>
                    </a></li>
                <?php
                }
                 
                ?>
                </ul>
                
                 <?php  
             
             
             // ********************************************************************************************************************
             
             // Выводим список врачей ****************************************************************************************
             /*if(!empty($_GET['r'])){
                 $rows = $wpdb->get_results($wpdb->escape( "SELECT * FROM ".$this->config->sql_table_clinik["doctor"]["name"] )." WHERE id_specialty = ".$_GET['r']);
                 
                 ?>
                <ul>
                <?php
                 
                foreach ($rows as $key=>$data){
                ?>
                    <li><a href="?r=<?php print $_GET['r'];?>">
                    <?php
                        print $data->name;
                    ?>
                    </a></li>
                <?php
                }
                 
                ?>
                </ul>
                 <?php  
             }*/
             // ********************************************************************************************************************
             
         }
        

    }
?>