<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/treadesouthwest
 * @since      1.0.0
 *
 * @package    Updown_Vote
 * @subpackage Updown_Vote/admin/partials
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! current_user_can('manage_options')) {
	return;
}

        ?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<!-- Add the icon to the page -->
			<div id="icon-themes" class="icon32"></div>
			<h2><?php echo esc_html__( 'UpDown Vote', $this->domain ); ?></h2>

			<!-- make a call to the WordPress function for rendering errors when settings are saved. -->
			<?php settings_errors(); ?>

			<?php
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] 
						: 'general_options';

			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=expert-help&tab=general_options" 
				class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?> ">
                <?php esc_html_e( 'General', $this->domain ); ?></a>
			</h2>

			<form method="post" action="options.php">

            <?php
            if( $active_tab == 'general_options' ) {
                settings_fields( 'general_options' );
                do_settings_sections( 'general_options' );
            }
            ?>
			<?php
        		submit_button();

        ?>
        </form>
        </div><!-- end .wrap -->
	<?php 

