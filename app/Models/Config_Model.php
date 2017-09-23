<?php
namespace To_Do\Models;

class Config_Model {

    private $config;

    private $properties = array();

    public function __construct() {
        $this->setup_plugin_config();
    }

    /**
     * Setup Plugin Config
     *
     * Sets up the plugin configuration options
     */
    private function setup_plugin_config() {
        $config = wp_cache_get( 'Config_Model', 'to-do' );

        if ( $config !== false ) {
            return $config;
        }

        $this->set( 'plugin_base_name', plugin_basename( TO_DO_PLUGIN_FILE ) );

        $plugin_headers = get_file_data(
            TO_DO_PLUGIN_FILE,
            array(
                'plugin_name'       => 'Plugin Name',
                'plugin_uri'        => 'Plugin URI',
                'description'       => 'Description',
                'author'            => 'Author',
                'version'           => 'Version',
                'author_uri'        => 'Author URI',
                'textdomain'        => 'Text Domain',
                'text_domain_path'  => 'Domain Path',
            )
        );

        $this->import( $plugin_headers );

        $this->set( 'prefix', '_todo_' );
        $this->set( 'plugin_path', TO_DO_PLUGIN_PATH );
        $this->set( 'plugin_file', TO_DO_PLUGIN_FILE );
        $this->set( 'plugin_url', TO_DO_PLUGIN_URL );
        $this->set( 'namespace', 'To_Do' );

        wp_cache_set( 'Config_Model', $config, 'to-do' );

        return $this->config = $config;
    }

    /**
     * Get config data
     *
     * @param $name
     * @return bool|mixed
     */
    public function get( $name ) {
        if ( isset( $this->properties[ $name ] ) ) {
            return $this->properties[ $name ];
        }

        return false;
    }

    /**
     * Set config data
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function set( $name, $value ) {
        $this->properties[ $name ] = $value;
        return $this;
    }

    /**
     * Import data object/array
     *
     * Imports an array or object of data
     *
     * @param $var
     * @return Config_Model|false
     */
    public function import ( $var ) {
        if ( ! is_array( $var ) && ! is_object( $var ) ) {
            return false;
        }

        foreach ( $var as $name => $value ) {
            $this->properties[ $name ] = $value;
        }

        return $this;
    }

    /**
     * Import config data via file
     *
     * @param string $file Path to a json formatted file
     *
     * @return Config_Model
     */
    public function import_json( $file ) {
        if ( ! file_exists( $file ) ) {
            die( 'Config file not found!' );
        }

        $config = json_decode( file_get_contents( $file ), true );

        $this->import( $config );

        return $this;
    }

}