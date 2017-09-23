<?php
namespace To_Do\Controllers;

/**
 * Admin Controller Class
 *
 * Functionality for the admin area of WordPress
 *
 * @package To_Do\Controller
 */
class Admin_Controller extends Controller {

    public function register_actions() {
        add_action( 'admin_init', array( $this, 'admin_init' ) );
    }

    public function admin_init() {
        // Do admin things
    }

}