<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/tradesouthwest
 * @since      1.0.0
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/includes
 */
namespace Updown_Vote;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Updown_Vote
 * @subpackage Updown_Vote/includes
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( 'updown_vote_date_plugin_activated' );
		return false;
	}

}
