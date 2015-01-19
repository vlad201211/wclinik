<?php
/*
Plugin Name: widgetclinik
Plugin URI: dxlab.ru
Description: dxlab plugins
Version: 1.0.0
Author: dxlab
Author URI: dxlab.ru
*/

// Выводит форму в админке 1123
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

add_filter('the_title', 'wclinik_world');
add_action('admin_menu', 'wclinik_admin_menu');

?>