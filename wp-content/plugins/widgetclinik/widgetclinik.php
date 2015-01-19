<?php
/*
Plugin Name: widgetclinik
Plugin URI: dxlab.ru
Description: dxlab plugins
Version: 1.0.0
Author: dxlab
Author URI: dxlab.ru
*/

// Выводит форму в админке 1111
function get_wclinik_form() {
?>
	<div class="wrap">
            <h2>Настройка виджета</h2>
            <form method="post" action="options.php">
                <?php wp_nonce_field('update-options'); ?>
                <h3>Введите текст:</h3>
                <input type="text" name="wclinik_1c_url" value="<?php echo get_option('wclinik_1c_url') ?>" /><br /><br />
                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="page_options" value="wclinik_1c_url" />
                <input type="submit" name="update" value="Сохранить">
            </form>
	</div>
<?php
} 

// Добавляем меню в админке cms
function wclinik_admin_menu(){
    add_menu_page('Виджет dxlab', 'Виджет dxlab', 8, basename(__FILE__), 'get_wclinik_form');
}

// Вешаем хук для теста, выводит заголовок плюс наш текст
function wclinik_world($title) {
	echo $title.' -> '.get_option('wclinik_1c_url');
}

// Вешаем хук
add_filter('the_title', 'wclinik_world');
// Добавляем в меню пункт
add_action('admin_menu', 'wclinik_admin_menu');



// Иницилизация
global $jal_db_version;
$jal_db_version = "1.0";

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