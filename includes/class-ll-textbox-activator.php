<?php

/**
 * Fired during plugin activation
 *
 * @link       netkeeper.pl
 * @since      1.0.0
 *
 * @package    Ll_Textbox
 * @subpackage Ll_Textbox/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ll_Textbox
 * @subpackage Ll_Textbox/includes
 * @author     Jacek Urban <jaceku20@gmail.com>
 */
class Ll_Textbox_Activator {

	/**
	 * Create database of words saved by user.
	 *
	 * @since    1.0.0
	 */
	public $chat_db_version = '1.0';
	
	public static function activate() {
		global $wpdb;
		global $chat_db_version;

		$table_name = $wpdb->prefix . 'learn_language';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			ll_id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) NOT NULL,
			ll_key VARCHAR(255) NOT NULL,
			ll_value LONGTEXT NOT NULL,
			ll_translation LONGTEXT NOT NULL,
			is_learned BOOLEAN,
			PRIMARY KEY (ll_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'chat_db_version', $chat_db_version ); 
	}
}