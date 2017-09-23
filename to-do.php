<?php
/*
* Plugin Name: To Do MVC
* Description: An example of an MVC plugin. Adds the ability to create to do lists in WordPress
* Version: 0.1.0
* License: GPL-2.0+
* Author URI: https://github.com/nate-allen
* Text Domain: to-do-mvc
* Domain Path: \languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Globals
 */
define( 'TO_DO_PLUGIN_FILE', __FILE__ );
define( 'TO_DO_PLUGIN_PATH', trailingslashit( __DIR__ ) );
define( 'TO_DO_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Autoload Classes
 */
include( TO_DO_PLUGIN_PATH . 'app/Core/Autoloader.php' );
$loader = new \To_Do\Core\Autoloader();
$loader->addNamespace('To_Do', dirname(__FILE__) . '/app');
$loader->register();

/***
 * Kick everything off when plugins are loaded
 */
add_action( 'plugins_loaded', 'to_do_init' );

/**
 * Callback for starting the plugin.
 *
 * @wp-hook plugins_loaded
 *
 * @return void
 */
function to_do_init() {
    $to_do = new \To_Do\Core\Bootstrap();

    try {
        $to_do->run();
    } catch ( Exception $e ) {
        wp_die( print_r( $e, true ) );
    }
}