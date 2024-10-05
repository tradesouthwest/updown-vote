<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/thatwpdeveloper
 * @since      1.0.0
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/public
 */
namespace Updown_Vote;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/public
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Public_Code {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Updown_Vote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Updown_Vote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'css/updown-vote-public.css', 
			array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Updown_Vote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Updown_Vote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, 
			plugin_dir_url( __FILE__ ) . 'js/updown-vote-public.js', 
			array( ), $this->version, false 
		);
		
		wp_enqueue_script( 'updownvote-ajax', 
		plugin_dir_url( __FILE__ ) . 'js/updown-vote-public.js', 
			array( ), $this->version, false 
		);
		
		wp_localize_script('updownvote-ajax', 
			'udv_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'postid'   => 'postId',
			'nonce'    => '_udv_nonce',
			'action'   => array( 'udv_upvote', 'udv_downvote' )
		));
	}

	public function register_shortcodes() {

		/**
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in _Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The _Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		add_shortcode( 'updownvote', [ $this, 'udv_display_votes' ] );
	}


    /**
     * Set actions for Ajax to return updownvote results
     * @since 1.0.1
     * @param int $post_id ID of current post
     */
    // AJAX handler for upvote
    public function udv_upvote() {
		/**
		 * Verifying nonce with sanitizing as per WPCS.
		 */
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( 
			$_REQUEST[ '_udv_nonce' ] ) ), '_udv_nonce' ) ) {
				return;
		}
        $post_id       = intval($_POST['post_id']);
        $current_votes = get_post_meta($post_id, 'up_vote', true) ?: 0;
        update_post_meta($post_id, 'up_vote', $current_votes + 1);
        wp_die();
    }
    
    // AJAX handler for downvote
    public function udv_downvote() {
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( 
			$_REQUEST[ 'udv-nonce' ] ) ), '_udv_nonce' ) ) {
				return;
		}
        $post_id = intval($_POST['post_id']);
        $current_voted = get_post_meta($post_id, 'down_vote', true) ?: 0;
        update_post_meta($post_id, 'down_vote', $current_voted + 1);
        wp_die();
    }

    /**
     * Plugin: Up Down Vote
     * Description: A simple plugin to upvote and downvote posts using a shortcode.
     * Version: 1.0
     * Author: Your Name
     */
    // Shortcode to display up and down vote buttons
    public function udv_display_votes($atts) {
        $atts = shortcode_atts(array(
            'id' => get_the_ID(),
        ), $atts);
        $post_id    = intval($atts['id']);
        $up_votes   = get_post_meta($post_id, 'up_vote', true) ?: 0;
        $down_votes = get_post_meta($post_id, 'down_vote', true) ?: 0;
		$action     = '_udv_nonce';
        ob_start();
        ?>
        <div class="udv-votes">
        <form method="post">    
			<button class="udv-upvote" 
            data-postid="<?php echo $post_id; ?>"><i></i> 
			<span><?php echo $up_votes; ?></span>
			<input name="action" type="hidden" value="udv_upvote" />
			<input type="hidden" id="udv-nonce" name="_udv_nonce" 
			value="<?php echo esc_attr( wp_create_nonce( $action ) ); ?>" /></button>

			<button class="udv-downvote" 
            data-postid="<?php echo $post_id; ?>"><i></i> 
			<span><?php echo $down_votes; ?></span>
			<input name="action" type="hidden" value="udv_downvote" />
			<input type="hidden" id="udv-nonce" name="_udv_nonce" 
			value="<?php echo esc_attr( wp_create_nonce( $action ) ); ?>" /></button>
		</form>
        </div>
        
        <?php
        return ob_get_clean();
    }

}
