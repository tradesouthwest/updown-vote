<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/thatwpdeveloper
 * @since      1.0.0
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/includes
 */
namespace Updown_Vote;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Updown_Vote
 * @subpackage Updown_Vote/includes
 * @author     That WP Developer <thatwpdeveloper@gmail.com>
 */
class i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'updown-vote',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
