<?php
/*
Plugin Name: widgetclinik
Plugin URI: dxlab.ru
Description: dxlab plugins
Version: 1.0.0
Author: dxlab
Author URI: dxlab.ru
*/


include_once 'class_widget.php';
include_once 'wconfig.php';
include_once 'class_parsel.php';


// Добавляем меню в админку cms ***************
function wclinik_admin_menu(){
    $widget = new widgetclinik();
    $widget->add_admin_menu();
}
add_action('admin_menu', 'wclinik_admin_menu');
// ********************************************


// Установка плагина *********************************
function wclinik_install(){
    $widget = new widgetclinik();
    $widget->install();
}
register_activation_hook(__FILE__, 'wclinik_install');
// ***************************************************

?>