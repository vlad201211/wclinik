<?php

// Иницилизация
global $jal_db_version;
$jal_db_version = "1.0";

// При активации вызываем ее
function jal_install () {
   global $wpdb;
   global $jal_db_version;

   // Имя тестовой таблицы
   $table_name = $wpdb->prefix . "liveshoutbox";
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
      $welcome_name = "Mr. Wordpress";
      $welcome_text = "Поздравляю, установка прошла успешно!";
      
      // Вносим данные в таблицу
      $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
      
      // Записываем версию
      add_option("jal_db_version", $jal_db_version);

   }
}

// Регистрируем версию
register_activation_hook(__FILE__,'jal_install');

?>