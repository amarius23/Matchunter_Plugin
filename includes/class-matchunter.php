<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://matchunter.com/
 * @since      1.0.0
 *
 * @package    Matchunter
 * @subpackage Matchunter/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Matchunter
 * @subpackage Matchunter/includes
 * @author     Matchunter <softize@gmail.com>
 */
class Matchunter {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Matchunter_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MATCHUNTER_VERSION' ) ) {
			$this->version = MATCHUNTER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'matchunter';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Matchunter_Loader. Orchestrates the hooks of the plugin.
	 * - Matchunter_i18n. Defines internationalization functionality.
	 * - Matchunter_Admin. Defines all hooks for the admin area.
	 * - Matchunter_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-matchunter-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-matchunter-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-matchunter-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-matchunter-public.php';

		$this->loader = new Matchunter_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Matchunter_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Matchunter_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Matchunter_Admin( $this->get_plugin_name(), $this->get_version() );

		//global scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_global_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_global_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_menu');

		// Plugin page action links
		$this->loader->add_filter( 'plugin_action_links_matchunter/matchunter.php', $plugin_admin, 'add_action_links' );

		$this->loader->add_action( 'admin_post_matchunter_save_options', $plugin_admin, 'save_options');

		$this->loader->add_action('admin_rest_api_init',$plugin_admin, 'rest_api_init');

		add_action( 'rest_api_init', function () {
			register_rest_route( 'matchunter/v1', '/user_data', array(
			'methods' => 'POST',
			'callback' => 'request_controller',
			'args' => array(
			  'id' => array(
			    'validate_callback' => function($param, $request, $key) {
			      return is_numeric( $param );
			    }
			   ),
		    ),
            ));
        });
	
		function request_controller( $request_data ) {
  		$data = array();

  		$parameters = $request_data->get_params();
  		$token = $parameters['token'];
  		$endpoints = $parameters['endpoints'];

  		if(isset($token) && isset($endpoints)){
  			$data['status'] = 'OK';
  			$data['recieved_data'] = array(
  				'token' => $token,
  				'endpoints' => $endpoints
  			);

  			$data['message'] = 'You have reached the server';
  			$data['Database'] = add_data($endpoints);
  		}else{
  			$data['status'] = 'Failed';
  			$data['message'] = 'Parameters Missing';
  		}
  		return $data;

		}

		function add_data($data){
			$conn = mysqli_connect(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
            // Check connection
            if (!$conn){
              die("Connection failed: " . mysqli_connect_error());
            }
        	$control = "SELECT endpoints FROM matchunter_client_endpoints";
            $sql = 'CREATE TABLE IF NOT EXISTS matchunter_client_endpoints(endpoints VARCHAR(1000));';
            if(mysqli_query($conn,$sql)){
            	$result = mysqli_query($conn, $control);
            	$serialized_data = serialize($data);	
	            if(mysqli_num_rows($result) == 0){ 
	            	$send = "INSERT INTO matchunter_client_endpoints(endpoints) VALUES ('$serialized_data');";
            	}
            	else $send = "UPDATE matchunter_client_endpoints SET endpoints = '".$serialized_data."' ;";
            }
             return (mysqli_query($conn, $send));
    		
		}
	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Matchunter_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_shortcode( 'matchunter', $plugin_public, 'handle_matchunter_shortcode', $priority = 10, $accepted_args = 2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Matchunter_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
