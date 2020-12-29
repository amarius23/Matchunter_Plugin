<?php

require MATCHUNTER_PATH.'/vendor/autoload.php';
use \GuzzleHttp\Client;
 /** * The admin-specific functionality of the plugin. * *
@link       https://matchunter.com/ * @since      1.0.0 * * @package   
Matchunter * @subpackage Matchunter/admin */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Matchunter
 * @subpackage Matchunter/admin
 * @author     Matchunter <softize@gmail.com>
 */
class Matchunter_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_global_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MATCHUNTER_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MATCHUNTER_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 $dependency_array = array();

		 $screen = get_current_screen();

		 //load this only on POST or PAGE screen
		 if ( $screen->base == 'post' && in_array( $screen->post_type, ['post','page']) ) {

		 }

		 //$dependency_array[] = 'wp-jquery-ui-dialog';

		 wp_register_style(
			 MATCHUNTER_DOMAIN . '_global_styles',
			 MATCHUNTER_ADMIN_ASSETS_URL . 'css/global.css',
			 $dependency_array, //dependency
			 MATCHUNTER_ASSET_VERSION,
			 'all'
		 );

		 wp_enqueue_style( MATCHUNTER_DOMAIN . '_global_styles' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_global_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MATCHUNTER_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MATCHUNTER_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$dependency_array = array(
		);

		$screen = get_current_screen();

		//load this only on POST or PAGE screen
		if ( $screen->base == 'post' && in_array( $screen->post_type, ['post','page']) ) {

		}

		wp_register_script(
		 MATCHUNTER_DOMAIN . '_global_scripts',
		 MATCHUNTER_ADMIN_ASSETS_URL . 'js/global.js',
		 $dependency_array,
		 MATCHUNTER_ASSET_VERSION,
		 true
		);

		$localization_array = array(
		 'ajaxurl' => admin_url( 'admin-ajax.php' ),
		 '_nonce' => wp_create_nonce( MATCHUNTER_NONCE ),
		 'admin_url' => MATCHUNTER_ADMIN_URL,
		 'assets_url' => MATCHUNTER_ADMIN_ASSETS_URL
		);
		wp_localize_script(	MATCHUNTER_DOMAIN . '_global_scripts', MATCHUNTER_DOMAIN, $localization_array );

		wp_enqueue_script( MATCHUNTER_DOMAIN . '_global_scripts' );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_menupage_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MATCHUNTER_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MATCHUNTER_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 $dependency_array = array();

		 $screen = get_current_screen();

		 //load this only on POST or PAGE screen
		 if ( $screen->base == 'post' && in_array( $screen->post_type, ['post','page']) ) {

		 }

		 //$dependency_array[] = 'wp-jquery-ui-dialog';

		 wp_register_style(
			 MATCHUNTER_DOMAIN . '_menupage_styles',
			 MATCHUNTER_ADMIN_ASSETS_URL . 'css/menupage.css',
			 $dependency_array, //dependency
			 MATCHUNTER_ASSET_VERSION,
			 'all'
		 );

		 wp_enqueue_style( MATCHUNTER_DOMAIN . '_menupage_styles' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_menupage_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MATCHUNTER_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MATCHUNTER_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$dependency_array = array(
		);

		$screen = get_current_screen();

		//load this only on POST or PAGE screen
		if ( $screen->base == 'post' && in_array( $screen->post_type, ['post','page']) ) {

		}

		wp_register_script(
		 MATCHUNTER_DOMAIN . '_menupage_scripts',
		 MATCHUNTER_ADMIN_ASSETS_URL . 'js/menupage.js',
		 $dependency_array,
		 MATCHUNTER_ASSET_VERSION,
		 true
		);

		$localization_array = array(
		 'ajaxurl' => admin_url( 'admin-ajax.php' ),
		 '_nonce' => wp_create_nonce( MATCHUNTER_NONCE ),
		 'admin_url' => MATCHUNTER_ADMIN_URL,
		 'assets_url' => MATCHUNTER_ADMIN_ASSETS_URL
		);
		wp_localize_script(	MATCHUNTER_DOMAIN . '_menupage_scripts', MATCHUNTER_DOMAIN, $localization_array );

		wp_enqueue_script( MATCHUNTER_DOMAIN . '_menupage_scripts' );

	}

	public function load_menupage_scripts(){
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_menupage_styles') );
		add_action( 'admin_enqueue_scripts', array($this, 'enqueue_menupage_scripts') );
	}

	public function register_menu(){
		$admin_pages = [];

		$admin_pages[] = add_menu_page(
			'Matchunter',
			'Matchunter',
			'manage_options',
			'matchunter', //slug
			array( $this, 'handle_overview' ),
			MATCHUNTER_ADMIN_ASSETS_URL.'img/favicon-16.png',
			27 );

		$admin_pages[] = add_submenu_page(
			'matchunter',
			__('Overview', ''),
			__('Overview', ''),
			'manage_options',
			'matchunter',
			array( $this, 'handle_overview' )
		);

		$admin_pages[] = add_submenu_page(
	    'matchunter',
	    __('Settings', ''),
	    __('Settings', ''),
	    'manage_options',
	    'matchunter_settings',
			array( $this, 'handle_matchunter_settings' )
	  );

		//hook scripts on all our plugin pages
		foreach($admin_pages as $admin_page){
			add_action( 'load-'.$admin_page, array($this, 'load_menupage_scripts') );
		}

		add_action('admin_init', array($this, 'settings_init') );
	}

	public function settings_init(){
		add_settings_section(
			'api-access-section', // id of the section
			'API Access', // title to be displayed
			'', // callback function to be called when opening section
			'mh-settings-page' // page on which to display the section, this should be the same as the slug used in add_submenu_page()
		);

		// register the setting
		register_setting(
			'mh-settings-page', // option group
			'api_token'
		);

		add_settings_field(
			'api-token', // id of the settings field
			'API Token', // title
			array($this, 'api_token_cb'), // callback function
			'mh-settings-page', // page on which settings display
			'api-access-section' // section on which to show settings
		);
	}

	public function api_token_cb() {
		$first_text = esc_attr(get_option('api_token', ''));

		?>
	  <input type="text" class="regular-text" name="api_token" value="<?php echo $first_text; ?>">
		<p class="description">Get your API Token <a href="https://matchunter.com/?mod=login" target="_blank">here</a>.</p>

		
		<?php
	}


	public function handle_overview(){
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}
		require_once( MATCHUNTER_PATH . 'admin/pages/overview.php' );
	}

	public function handle_matchunter_settings(){
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}

		require_once( MATCHUNTER_PATH . 'admin/pages/settings.php' );
	}

	/**
	 * Add action links in plugin list page.
	 *
	 * @since		1.0.0
	 * @access	public
	 * @param		array $links
	 */
	public function add_action_links ( $links ) {
		$mylinks = array(
 			'<a href="' . MATCHUNTER_PANEL_URL . '">Settings</a>',
 			//'<a style="background:green;color:#fff;border-radius:3px;padding:2px 10px;" href="' . MATCHUNTER_PANEL_URL . '">Get support</a>',
		);

		return array_merge( $links, $mylinks );
	}

}
