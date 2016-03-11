<?php

namespace WooBoPolis;

/*
  Plugin Name: WooBoPolis
  Plugin URI:  https://github.com/ctala/WooBoPolis
  Description: Este plugin envía la información de una orden completa a CuboPolis.
  Version:     1.0
  Author:      Cristian Tala Sánchez
  Author URI:  http://www.cristiantala.cl
  License:     MIT
  License URI: http://opensource.org/licenses/MIT
  Domain Path: /languages
  Text Domain: ctala-text_domain
 */

include_once 'vendor/autoload.php';

use WooBoPolis\classes\Logger;
use CuboPolis\Trx;
use WooBoPolis\views\SettingsMenu;

function woocommerce_order_status_completed($order_id) {
    Logger::log_me_wp("Orden Completada : $order_id", __CLASS__);
    $cubopolisTRX = new Trx;

    
    //Tokens
    $cubopolisTRX->set_access_token(get_option("cubopolis_access_token"));
    $cubopolisTRX->set_resource_token(get_option("cubopolis_resource_token"));
    
    if("on" === get_option("cubopolis_desarrollo_toggle"))
    {
        $cubopolisTRX->set_CUBOPOLISAPIURL(get_option("cubopolis_desarrollo_url"));
    }
    
    
    //Obtengo la Orden de Woocommerce
    $order = new \WC_Order($order_id);
    Logger::log_me_wp($order, __CLASS__);

    $cubopolisTRX->nPedido = $order->id;
    $cubopolisTRX->fecha = $order->order_date;
    $cubopolisTRX->subTotal = $order->get_subtotal();
    $cubopolisTRX->total = $order->get_total();
    $cubopolisTRX->descuentos = $order->get_total_discount();
    $cubopolisTRX->tipoTRX = $order->payment_method;

    Logger::log_me_wp($cubopolisTRX, __CLASS__);

    
    
    Logger::log_me_wp($cubopolisTRX->sendToServer(),__FUNCTION__);
}

add_action('woocommerce_order_status_completed', 'WooBoPolis\woocommerce_order_status_completed');

// Registramos los menus correspondientes
function ctala_setup_admin_menu() {
    add_options_page("CuboPolis Settings", "CuboPolis Settings", 'manage_options', 'cubopolis', "WooBoPolis\ctala_view_admin");
}

function ctala_view_admin() {
    SettingsMenu::generateSettings();
}

add_action('admin_menu', 'WooBoPolis\ctala_setup_admin_menu');
?>