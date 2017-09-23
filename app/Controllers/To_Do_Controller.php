<?php
namespace To_Do\Controllers;

use \To_Do\Models\To_Do_Model;

/**
 * To Do Controller Class
 *
 * @package To_Do\Controller
 */
class To_Do_Controller extends Controller {

    public function register_actions() {
        add_action( 'init', array( $this, 'register_custom_post_type' ) );

        add_shortcode( 'to_do_list', array( $this, 'to_do_list_shortcode' ) );
        add_shortcode( 'add_to_do_form', array( $this, 'add_to_do_form_shortcode' ) );
    }

    /**
     * Register the 'to do' post type
     *
     * @wp-hook init
     * @since 1.0.0
     */
    public function register_custom_post_type() {
        $to_do_model = new To_Do_Model();
        register_post_type( 'To Do', $to_do_model->get_args() );
    }

    /**
     * To Do List shortcode
     *
     * Logic for the [to_do_list] shortcode
     *
     * @param $atts
     * @param string $content
     *
     * @return string To do list view
     */
    public function to_do_list_shortcode( $atts, $content = '' ) {
        $atts = shortcode_atts( array(
            'number' => 20,
            'classes' => 'to-do-list',
        ), $atts, 'to_do_list' );

        $to_do_model = new To_Do_Model();

        $to_do_model->get_to_dos( array(
            'number' => $atts['number'],
        ) );

        $this->assign( 'to_do', $to_do_model );
        $this->assign( 'classes', $atts['classes'] );
        $this->assign( 'content', $content );

        return $this->get_view( 'frontend/to_do_list' );
    }

    /**
     * Add To Do Form shortcode
     *
     * Logic for the [add_to_do_form] shortcode
     *
     * @param $atts
     * @param string $content
     *
     * @return string
     */
    public function add_to_do_form_shortcode( $atts, $content = '' ) {
        $atts = shortcode_atts( array(
            'heading_text'     => '',
            'description_text' => '',
        ), $atts, 'add_to_do_form' );

        $to_do_model = new To_Do_Model();

        $this->assign( 'to_do', $to_do_model );
        $this->assign( 'content', $content );

        return $this->get_view( 'frontend/add_to_do_form' );
    }
}
