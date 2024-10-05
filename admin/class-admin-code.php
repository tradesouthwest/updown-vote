<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tradesouthwest
 * @since      1.0.0
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/admin
 */
namespace Updown_Vote;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/admin
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Admin_Code {

	/**
	 * Name of the plugin
	 * @var string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
	 * Name of the plugin
	 * @var string
	 */
	private $domain;

    /**
	 * Options getter of the plugin
	 * @var string
	 */
    private $options_get;

    /**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  string $
	 * @param  string $
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
        $this->domain       = 'updown-vote';
        $this->options_get  = $this->options_get;
         
    }
	
    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * The Updown_Vote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name . '-admin-style', plugin_dir_url( __FILE__ ) . 'css/updown-vote-admin.css', array(), $this->version, 'all' );
	}

    /**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name . '-admin-script', plugin_dir_url( __FILE__ ) . 'css/updown-vote-admin.js', array(), $this->version, 'all' );
    }

    /**
     * Called from loader \Core
     * 
     * @since 1.0.0
     * @return HTML
     */
    /**
     * @param string $id, 
     * @param string $title, 
     * @param callable $callback, 
     * @param string|array|WP_Screen $screen, 
     */

    public function add() {
    add_meta_box('updown-vote', 
                __( 'Votes', $this->domain ), 
                [ $this, 'meta_callback' ],
                'post', 
                'side', 'default');
    }
    /**
     *  saves the data entered in the metaboxes when the post is saved.
     */
    // Save Metabox Data
    public function save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (isset($_POST['up_vote'])) {
            update_post_meta($post_id, 'up_vote', intval($_POST['up_vote']));
        }
        if (isset($_POST['down_vote'])) {
            update_post_meta($post_id, 'down_vote', intval($_POST['down_vote']));
        }
    }
    /**
     *  render the input fields for the metaboxes.
     */
    public function meta_callback($post) {
        $up_vote = get_post_meta($post->ID, 'up_vote', true);
        $down_vote = get_post_meta($post->ID, 'down_vote', true);
        echo '<p><label for="up_vote">Up Vote:</label> 
            <input type="number" name="up_vote" value="' . esc_attr($up_vote) . '" size="6"></p>';
        echo '<p><label for="down_vote">Down Vote:</label> 
            <input type="number" name="down_vote" value="' . esc_attr($down_vote) . '" size="6"></p>';
    }

    /**
     * Add the menu page.
     *
     * @since    1.0.0
     * string $page_title, string $menu_title, string $capability, 
     * string $menu_slug, callable $callback = ”, 
     * string $icon_url = ”, int|float $position = null ): string
     */
    public function add_menu(){
        add_menu_page(
            __( 'UpDown Vote', $this->domain ),
            __( 'UpDown Votes', $this->domain ),
            'manage_options',
            'updown-vote',            
            [ $this, 'plugin_settings_page' ],
            'dashicons-plus',
            99
        );
    }

    /**
     * get_option('general_options')['workroom_uri'],
     */
    public function options_get( $opt, $fld ){

        $options_get = ( empty( get_option( $opt )[ $fld ] ) ) 
                      ? '' : get_option( $opt )[ $fld ];

            return esc_attr( $options_get );
    }

    /**
     * Initializes the Sections, Field, and Settings
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initialize_options() {

        /* section
         * $id, $title, $callback, $page
         */  
        add_settings_section(
            'general_options',
            '',          
            [ $this, 'general_options_callback_a' ],
            'general_options' 
        );
    
        /* @option_name[array_key] = $option[$arg]
         * $id, $label, $callback, $page, $section, $args
         */ 
        add_settings_field(
            'updownv_title', 					
            __( 'Vote Title', $this->domain ), 
            [ $this, 'updown_vote_textinput' ],
            'general_options',
            'general_options',
            array( 
                'label_for'   => 'updownv_title', 
                'name'        => 'updownv_title', 
                'value'       => $this->options_get(
                                    'general_options',
                                    'updownv_title'),
                'option_name' => 'general_options',
                'show_link'   => false
            )
        );
        add_settings_field(
            'updownv_before', 					
            __( 'Before Text', $this->domain ), 				
            [ $this, 'updown_vote_textinput' ],
            'general_options',
            'general_options',
            array( 
                'label_for'   => 'updownv_before', 
                'name'        => 'updownv_before', 
                'value'       => $this->options_get(
                                    'general_options',
                                    'updownv_before'),
                'option_name' => 'general_options',
                'show_link'   => false
            )
        );
        add_settings_field(
            'updownv_after', 					
            __( 'After text', $this->domain ),  					
            [ $this, 'updown_vote_textinput' ],
            'general_options',
            'general_options',
            array( 
                'label_for'   => 'updownv_after', 
                'name'        => 'updownv_after', 
                'value'       => $this->options_get(
                                    'general_options',
                                    'updownv_after'),
                'option_name' => 'general_options',
                'show_link'   => false
            )
        );
	    register_setting( 'general_options',
		    'general_options'
	    );
        
    }

    /**
     * Display the plugin settings page if the user has sufficient privileges.
     *
     * @since    1.0.0
     */
    public function plugin_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Sorry! You don\'t have sufficient permissions to access this page.', $this->domain ) );
        }

        include( sprintf( "%s/partials/updown-vote-admin-display.php", 
			dirname( __FILE__ ) ) 
		);
    }

    /* ////////// Section Callbacks ////////// */
    /**
     * description for the General Options page.
     */
    public function general_options_callback_a() {
        echo '<p>' . esc_html__( 'General Options and Settings', $this->domain ) . '</p>';
    } 
    // extra options description
    public function extra_options_callback() {
        echo '<p>' . esc_html__( 'Content for Extra page heading', $this->domain ) . '</p>';
    } 
    // extra options description
    public function more_options_callback() {
        echo '<p>' . esc_html__( 'Content for More page heading', $this->domain ) . '</p>';
    } 

    /* ////////// FIELDs ////////// */
     /**
     * Path to input field render html.
     * Can be use as text, uri, number.
     */
    public function updown_vote_textinput( $args ){
        if ( !$args['show_link'] || $args['show_link'] === '' ) {
        printf(
            '<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
            $args['option_name'],
            $args['name'],
            $args['label_for'],
            $args['value'] 
        );
        } else {
            printf(
                '<input name="%1$s[%2$s]" id="%3$s" value="%4$s" class="regular-text">',
                $args['option_name'],
                $args['name'],
                $args['label_for'],
                $args['value'] 
            );
            printf(
                '&nbsp;<a href="%1$s" title="%2$s" target="%3$s">%1$s <span title="opens in new tab">&#x2197;</span></a>',
                $args['value'],
                $args['name'],
                esc_attr( '_blank' )
                 
            );
        }
    }

    /* ////////// Admin specific methods ////////// */
    /**
     * Display the date this plugin was activated, last.
     * 
     * @since 1.0.0
     * @param string $da Option added in \Activate
     */
    public function date_plugin_activated_field() {
        $da = ( empty ( get_option( 'updown_vote_date_plugin_activated' ) ) ) 
                ? '' : get_option( 'updown_vote_date_plugin_activated' );
        echo esc_attr( $da );
    }

    /**
     * validate and sanitize text input
     * 
     * @since 1.0.0
     */
    public function validate_input_general( $input ) {
        // The array in which the new, sanitized input will go
        $new_input = array();
        
        // Read the company name from the array of options
        $val = $input['name'];
        
        // Sanitize the information
        $val = strip_tags( stripslashes( $val ) );
        $new_input['name'] = sanitize_text_field( $val );
        
        return $new_input;
        
    }
}
