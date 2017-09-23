<?php
namespace To_Do\Core;

use To_Do\Models\Config_Model;

class View {

    /**
     * Plugin configuration settings
     *
     * @var Config_Model
     */
    protected $config;

    /**
     * View constructor.
     */
    public function __construct() {
        $this->config = new Config_Model();
    }

    /**
     * Variables for substitution in templates.
     *
     * @var array
     */
    protected $variables = array();

    /**
     * Assign variable for substitution in templates.
     *
     * @param string $variable Name variable to assign
     * @param mixed $value Value variable for assign
     *
     * @return void
     */
    public function assign( $variable, $value ) {
        $this->variables[ $variable ] = $value;
    }

    /**
     * Echo the view.
     *
     * Useful for meta boxes because the markup needs to be echoed
     *
     * @param string $file File to get HTML string
     * @param string $view_dir View directory
     *
     * @return void
     */
    public function the_view( $file, $view_dir = null ) {
        foreach ( $this->variables as $key => $value ) {
            ${$key} = $value;
        }

        $view_dir  = isset( $view_dir ) ? $view_dir : TO_DO_PLUGIN_PATH . '/views/';
        $view_file = $view_dir . $file . '.php';

        if ( ! file_exists( $view_file ) ) {
            return;
        }

        include_once( $view_file );
    }

    /**
     * Return the view
     *
     * Useful for shortcodes because the markup needs to be returned
     *
     * @paramg string $file File to get HTML string
     * @param string $view_dir View directory
     *
     * @return string $html HTML output as string
     */
    public function get_view( $file, $view_dir = null ) {
        foreach ( $this->variables as $key => $value ) {
            ${$key} = $value;
        }

        $view_dir  = isset( $view_dir ) ? $view_dir : TO_DO_PLUGIN_PATH . '/view/';
        $view_file = $view_dir . $file . '.php';
        if ( ! file_exists( $view_file ) ) {
            return '';
        }

        ob_start();
        include( $view_file );
        $thread = ob_get_contents();
        ob_end_clean();
        $html = $thread;

        // reset the $variables
        $this->init_assignments();

        return $html;
    }

    /**
     * Reset the variables
     *
     * After the view is used, this will clear out the variables
     */
    protected function init_assignments() {
        $this->variables = array();
    }
}