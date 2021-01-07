<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://matchunter.com/
 * @since      1.0.0
 *
 * @package    Matchunter
 * @subpackage Matchunter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Matchunter
 * @subpackage Matchunter/public
 * @author     Matchunter <softize@gmail.com>
 */
class Matchunter_Public {

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

	private $api_token;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->api_token = esc_attr(get_option('api_token', false));

	}

	/**
	 * Make a server request by shortcode attr
	 *
	 * @since		1.0.0
	 * @param  params  it is an associative array that contains all the attributes to make request to a specific endpoint
	 * @return response   html to display
	 * @since 				1.0.0.0
	 *
	 */
	
	protected function make_request($params) {

		$conn = mysqli_connect(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
			// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$control = "SELECT token FROM matchunter_client_token";
		$result = mysqli_query($conn, $control);
		$row = mysqli_fetch_assoc($result);

		$client = new \GuzzleHttp\Client();
		try {
			if($params['type'] == 'round_list')
			$response = $client->request('GET', MATCHUNTER_API['root'].MATCHUNTER_API['names'][$params['type']]['endpoint'].'/'.'1'.'?token='.$row['token']);
		
			if($params['type'] == 'tournament_ranking')
			$response = $client->request('GET', MATCHUNTER_API['root'].MATCHUNTER_API['names'][$params['type']]['endpoint'].'/'.$params['tournament_id'].'/'.$params['page'].'?token='.$row['token']);
		
			if($params['type'] == 'round_ranking')
			$response = $client->request('GET', MATCHUNTER_API['root'].MATCHUNTER_API['names'][$params['type']]['endpoint'].'/'.$params['tournament_id'].'/'.$params['round_number'] .'/'.$params['page'].'?token='.$row['token']);

			if($params['type'] == 'round_matches')
			$response = $client->request('GET',MATCHUNTER_API['root'].'/active/round/'.$params['tournament_id'].'/matches'.'?token='.$row['token']);

			if($params['type'] == 'insights')
			$response = $client->request('GET', MATCHUNTER_API['root'].'/'.$params['match_id'].'/insights?token='.$row['token']);
		
			if($params['type'] == 'lineup')
			$response = $client->request('GET', MATCHUNTER_API['root'].'/'.$params['match_id'].'/lineup?token='.$row['token']);
					
			return $response->getBody();
		}
		catch (GuzzleHttp\Exception\ClientException $e) {
			$response = $e->getResponse();
			$responseBodyAsString = $response->getBody();
			return $responseBodyAsString;
		}
	}
	/**
	 * Portfolio editor shortcode
	 *
	 * @since		1.0.0
	 * @param  array  $atts   	shortcode attributes
	 * @param  string $content	content between shortcode tags if using the long version of shortcode
	 * @return string        		string to display
	 * @since 				1.0.0.0
	 *
	 */
	public function handle_matchunter_shortcode( $atts, $content='' ) {
		$atts = shortcode_atts(
			array(
				'type'=> '',
				'page'=> '',
				'match_id'=> '',
				'round_number'=> '',
				'tournament_id'=> ''
			),
			$atts,
			'matchunter'
		);

		$type			= $atts['type'];
		$page 			= $atts['page'];
		$match_id		= $atts['match_id'];
		$round_number	= $atts['round_number'];
		$tournament_id	= $atts['tournament_id'];

		$params 		= array_filter($atts);
		$json_params 	= htmlspecialchars(json_encode($params), ENT_QUOTES, 'UTF-8');
		ob_start();
		?>
		
		<?php echo $this->make_request($params);?>
		<?php 
			if(isset($_POST['submit'])){
				echo '<h1 style="color:red;">'.$_POST['title'].'</h1>';
			}
		?>
		
		
		<!-- <div class="matchunter-container" data-params="<?php echo $json_params;?>"></div> -->
		<?php

		return ob_get_clean();
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
		 * defined in Matchunter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Matchunter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 wp_register_style(
			 MATCHUNTER_DOMAIN . '_public_styles',
			 MATCHUNTER_PUBLIC_ASSETS_URL . 'css/public.css',
			 array(), //dependency
			 MATCHUNTER_ASSET_VERSION,
			 'all'
		 );
		 wp_enqueue_style( MATCHUNTER_DOMAIN . '_public_styles' );
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
		 * defined in Matchunter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Matchunter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 wp_register_script(
			 MATCHUNTER_DOMAIN . '_public_scripts',
			 MATCHUNTER_PUBLIC_ASSETS_URL . 'js/public.js',
			 array('jquery'), //dependencies
			 MATCHUNTER_ASSET_VERSION,
			 true
		 );
		 $localization_array = array(
	    'ajaxurl' => admin_url( 'admin-ajax.php' ),
	    '_nonce' => wp_create_nonce( MATCHUNTER_NONCE ),
	    'public_assets_url' => MATCHUNTER_PUBLIC_ASSETS_URL,
			'token' => $this->api_token,
			'api' => htmlspecialchars(json_encode(MATCHUNTER_API), ENT_QUOTES, 'UTF-8')
	   );
	   wp_localize_script(MATCHUNTER_DOMAIN . '_public_scripts', MATCHUNTER_DOMAIN, $localization_array );
	   wp_enqueue_script( MATCHUNTER_DOMAIN . '_public_scripts' );
	}

}
