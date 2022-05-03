<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       netkeeper.pl
 * @since      1.0.1
 *
 * @package    Ll_Textbox
 * @subpackage Ll_Textbox/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ll_Textbox
 * @subpackage Ll_Textbox/public
 * @author     Jacek Urban <jaceku20@gmail.com>
 */
class Ll_Textbox_Public {

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
	 * The database name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    Database name of this plugin.
	 */
	private $database_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $database_name ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->database_name = $database_name;

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
		 * defined in Ll_Textbox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ll_Textbox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ll-textbox-public.css', array(), $this->version, 'all' );

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
		 * defined in Ll_Textbox_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ll_Textbox_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( 'ajax', plugin_dir_url( __FILE__ ) . 'js/ll-textbox-public-ajax.js', array('jquery'), $this->version, true );	

	}

	public function save_word() {
		global $wpdb;
		$table = $this->database_name;
		// Sanitise POST values
		$ll_value = sanitize_text_field( $_POST['ll_value'] );
		$ll_translation = sanitize_text_field( $_POST['ll_translation'] );
		$is_learned = rest_sanitize_boolean( $_POST['is_learned'] );

		// Check if POSTed word exists already in users records
		$does_word_exist = $wpdb->get_results("SELECT ll_value FROM " . $table . " WHERE user_id=1 AND ll_value='" . $ll_value . "'");

		if(!empty($does_word_exist)) {
			wp_send_json(array('response' => 'Word already saved'));
		} else {
			$data = array('user_id' => get_current_user_id(), 'll_key' => 'new_word', 'll_value' => $ll_value, 'll_translation' => $ll_translation, 'is_learned' => $is_learned);
			$format = array('%s','%d');
			$success = $wpdb->insert($table,$data,$format);
			wp_send_json(array('response' => 'Saved'));
		}
	}

	public function textbox_shortcode($atts) {
		$api_key = get_option('ll_textbox_API_key');

		$a = shortcode_atts( array(
			'text' => '',
			'source' => 'PL',
			'target' => 'EN'
		), $atts );
	
		ob_start();
		?>
			<div class="textbox">
				<?php if(empty($api_key) || !$api_key): ?>
					<div class="error">Fill in your API key in <a href="<?php echo get_site_url() ?>/wp-admin/options-general.php?page=ll-textbox-settings" target="_blank">settings</a></div>
				<?php endif; ?>
				<div class="textbox-inner">
					<?php echo esc_html( $a['text'] ) ?>
				</div>
			</div>
		<?php
		wp_enqueue_style($this->plugin_name);
		wp_enqueue_script('ajax');
		wp_localize_script( 'ajax', 'my_ajax_object', array( 
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'API_key' => get_option('ll_textbox_API_key'),
			'source' => esc_html($a['source']),
			'target' => esc_html($a['target'])
		), null, true );

		return ob_get_clean();
	}

	public function saved_words_shortcode($atts) {
		require_once 'partials/'.$this->plugin_name.'-public-words-display.php';
	}

}