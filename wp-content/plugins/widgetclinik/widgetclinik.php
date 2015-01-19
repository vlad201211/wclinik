<?php
/*
Plugin Name: widgetclinik
Plugin URI: dxlab.ru
Description: dxlab plugins
Version: 1.0.0
Author: dxlab
Author URI: dxlab.ru
*/


include_once 'install.php';
include_once 'class_widget.php';
include_once 'wconfig.php';


// Добавляем меню в админке cms
function wclinik_admin_menu(){
    $widget = new widgetclinik();
    $widget->add_admin_menu();
}
// Добавляем в меню пункт
add_action('admin_menu', 'wclinik_admin_menu');

?>