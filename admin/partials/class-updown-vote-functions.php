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
class Updown_Vote_Functions {

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
         
    }
/**
 * adds two metaboxes: one for votes 
 */
function add_updown_vote_metaboxes() {
    add_meta_box('post', 
                'Votes', 
                'updown_vote_votes_callback', 
                'updown_vote', 
                'side', 'default');
  /*  add_meta_box('updownvote_fields', 
                'UpdownVote Fields', 
                'updown_vote_fields_callback', 
                'updown_vote', 
                'side', 'default'); */
}
add_action('add_meta_boxes', 'add_updown_vote_metaboxes');

// Callback for Votes Metabox
/**
 *  render the input fields for the metaboxes.
 */
function updown_vote_votes_callback($post) {
    $up_vote = get_post_meta($post->ID, 'up_vote', true);
    $down_vote = get_post_meta($post->ID, 'down_vote', true);
    echo '<label for="up_vote">Up Vote:</label> <input type="number" name="up_vote" value="' . esc_attr($up_vote) . '"><br>';
    echo '<label for="down_vote">Down Vote:</label> <input type="number" name="down_vote" value="' . esc_attr($down_vote) . '"><br>';
}

// Callback for Custom Fields Metabox 
/*
function updown_vote_fields_callback($post) {
    for ($i = 1; $i <= 4; $i++) {
        $field_value = get_post_meta($post->ID, "field_$i", true);
        echo '<label for="field_$i">Field ' . $i . ':</label> <input type="text" name="field_' . $i . '" value="' . esc_attr($field_value) . '"><br>';
    }
}
*/
/**
 *  saves the data entered in the metaboxes when the post is saved.
 */
// Save Metabox Data
function save_updown_vote_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['up_vote'])) {
        update_post_meta($post_id, 'up_vote', intval($_POST['up_vote']));
    }
    if (isset($_POST['down_vote'])) {
        update_post_meta($post_id, 'down_vote', intval($_POST['down_vote']));
    }
    /*
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_POST["field_$i"])) {
            update_post_meta($post_id, "field_$i", sanitize_text_field($_POST["field_$i"]));
        }
    } */
}
add_action('save_post', 'save_updown_vote_meta'); 
