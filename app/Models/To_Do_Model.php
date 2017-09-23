<?php
namespace To_Do\Models;

class To_Do_Model {

    /**
     * The To Do ID
     *
     * @var    integer
     */
    public $ID = 0;

    /**
     * Title of the to do
     *
     * @var string
     */
    public $title = '';

    /**
     * Slug for the to do
     *
     * @var string
     */
    public $slug = '';

    /**
     * Content for the to do
     *
     * @var string
     */
    public $content = '';

    /**
     * Labels for the custom post type
     *
     * @var array
     */
    private $labels = array();

    /**
     * Plugin config model
     *
     * @var Config_Model
     */
    private $config;

    /**
     * Arguments for the custom post type
     *
     * @var array
     */
    private $args = array();

    /**
     * To_Do_Model constructor.
     *
     * @param int $id
     */
    function __construct( $id = 0 ) {
        $this->config = new Config_Model();

        // Set the $labels for the To Do CPT
        $this->set_labels();

        // Set the $args for the To Do CPT
        $this->set_args();

        if ( ! empty( $id ) ) {
            $id = absint( $id );

            $to_do = get_post( $id );

            if ( ! empty( $to_do ) ) {
                $this->setup_model( $to_do );
            }
        }

    }

    /**
     * Setup the model properties
     *
     * @since  1.0.0
     * @param  object $todo To do post object
     */
    private function setup_model( $todo ) {
        $this->ID = absint( $todo->ID );
        $this->title = $todo->post_title;
        $this->slug = $todo->post_name;
        $this->content = $todo->post_content;
    }

    /**
     * Get To Do CPT args
     *
     * @return array
     */
    public function get_args() {
        return $this->args;
    }

    /**
     * Get an array of To Do models
     *
     * @param array $args
     *
     * @return array Array of To Do models
     */
    public function get_to_dos( $args ) {
        $defaults = array(
            'number' => 20,
            'fields' => 'ids',
            'post_type' => 'to_do',
        );

        $args = wp_parse_args( $args, $defaults );

        $query = new \WP_Query( array(
            'posts_per_page' => $args['number'],
            'post_type'      => 'to_do',
            'fields'         => 'ids',
        ) );

        // Empty array to fill with To Do models
        $results = array();

        foreach ( $query->posts as $id ) {
            $results[] = new self( $id );
        }

        return $results;
    }

    /**
     * Sets $labels to the translated labels
     */
    private function set_labels() {
        $default_labels = array(
            'name'                  => _x( 'To Dos', 'General Name', 'to-do' ),
            'singular_name'         => _x( 'To Do', 'Singular Name', 'to-do' ),
            'menu_name'             => __( 'To Dos', 'to-do' ),
            'name_admin_bar'        => __( 'To Do', 'to-do' ),
            'archives'              => __( 'To Do Archives', 'to-do' ),
            'attributes'            => __( 'To Do Attributes', 'to-do' ),
            'parent_item_colon'     => __( 'Parent To Do:', 'to-do' ),
            'all_items'             => __( 'All To Dos', 'to-do' ),
            'add_new_item'          => __( 'Add New To Do', 'to-do' ),
            'add_new'               => __( 'Add New', 'to-do' ),
            'new_item'              => __( 'New To Do', 'to-do' ),
            'edit_item'             => __( 'Edit To Do', 'to-do' ),
            'update_item'           => __( 'Update To Do', 'to-do' ),
            'view_item'             => __( 'View To Do', 'to-do' ),
            'view_items'            => __( 'View To Dos', 'to-do' ),
            'search_items'          => __( 'Search To Do', 'to-do' ),
            'not_found'             => __( 'Not found', 'to-do' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'to-do' ),
            'featured_image'        => __( 'Featured Image', 'to-do' ),
            'set_featured_image'    => __( 'Set featured image', 'to-do' ),
            'remove_featured_image' => __( 'Remove featured image', 'to-do' ),
            'use_featured_image'    => __( 'Use as featured image', 'to-do' ),
            'insert_into_item'      => __( 'Insert into to do', 'to-do' ),
            'uploaded_to_this_item' => __( 'Uploaded to this to do', 'to-do' ),
            'items_list'            => __( 'To Dos list', 'to-do' ),
            'items_list_navigation' => __( 'To Dos list navigation', 'to-do' ),
            'filter_items_list'     => __( 'Filter to do releases list', 'to-do' ),
        );

        $this->labels = apply_filters( 'to_do_cpt_labels', $default_labels );
    }

    /**
     * Sets $labels to the translated labels
     */
    private function set_args() {
        $default_args = array(
            'label'                 => __( 'To Do', 'to-do' ),
            'description'           => __( 'To Dos', 'to-do' ),
            'labels'                => $this->labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'show_in_rest'          => true,
            'rest_base'             => 'To_Do',
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'menu_icon'             => 'dashicons-clipboard',
        );

        $this->args = apply_filters( 'to_do_cpt_args', $default_args );
    }

}