<?php
	$title = "Overview";

	require_once( MATCHUNTER_PATH . 'admin/partials/header.php');
		
		/*
		*Getting all client endpoints from MySQL Databse
		*/
		function get_endpoints() {

			//Getting token from database to make tournament and round requests.
			$conn = mysqli_connect(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
			// Check connection
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			$control = "SELECT token FROM matchunter_client_token";
			$result = mysqli_query($conn, $control);
			$token = mysqli_fetch_assoc($result)['token'];
			$endpoints = array();
			//Getting Matchunter user tournament list 
			$client = new \GuzzleHttp\Client();
			try {

				$tournament_list = $client->request('GET', 'http://78.46.160.168:5000/api/tournaments/list/page/1?token='.$token)->getBody()->getContents();
				$tournament_list = json_decode($tournament_list,true);
				$tournament_datas =  $tournament_list['data'];
				$round_list;

				foreach ($tournament_datas as $id) {

					array_push($endpoints, MATCHUNTER_API['root'].MATCHUNTER_API['names']['round_list']['endpoint']. '/'.$id['id']);
					array_push($endpoints, MATCHUNTER_API['root'].MATCHUNTER_API['names']['tournament_ranking']['endpoint']. '/'.$id['id'].'/1');
					array_push($endpoints, MATCHUNTER_API['root'].MATCHUNTER_API['names']['round_matches']['endpoint'].'/'. $round['number'].$id['id']);
			
					$round_list = $client->request('GET','http://78.46.160.168:5000/api/rounds/tournament/'.$id['id'].'/rounds?token='.$token)->getBody()->getContents();
					$round_list = json_decode($round_list,true);
					$round_list = $round_list['rounds'];

					foreach ($round_list as $round) {
						$round_number = $round['number'];
						array_push($endpoints, MATCHUNTER_API['root'].MATCHUNTER_API['names']['round_ranking']['endpoint'].'/'.$id['id'].'/'. $round['number'].'/1');
					}			
				}
			}
			catch (GuzzleHttp\Exception\ClientException $e) {
				$response = $e->getResponse();
				var_dump($response->getBody()->getContents());
			}

			return $endpoints;
		}

		$endpoints = get_endpoints();

		/*
			The generatior of descripiton section in overview submenu.
			
			Gives the description to display to the client , it gets the endpoints and define specific description for them.
		*/
		function generate_descriptions($endpoints) {
		$descriptions = array();
		if(empty($endpoints)) {
			return null;
		} else {
			foreach ($endpoints as $endpoint) {
				
				if(strpos($endpoint, "round/list") !== false) {
					array_push($descriptions,"round list is blablalbalbladl alas alb aslvasl al avladbl abj abab a;babh ia;b apba lbah bah vkab");
				}
				if(strpos($endpoint, "tournament/ranking") !== false) {
					array_push($descriptions,"tournament ranking is blablalbalbladl alas alb aslvasl al avladbl abj abab a;babh ia;b apba lbah bah vkab");
				}
				if(strpos($endpoint, "round/ranking") !== false) {
					array_push($descriptions,"round ranking is blablalbalbladl alas alb aslvasl al avladbl abj abab a;babh ia;b apba lbah bah vkab");
				}
				if(strpos($endpoint, "round/matches") !== false) {
					array_push($descriptions,"round matches is blablalbalbladl alas alb aslvasl al avladbl abj abab a;babh ia;b apba lbah bah vkab");
				}
			}
			return $descriptions;
		}
	}
		/*
			The generatior of shortcodes section in overview submenu.
			
			Based on the endpoints from data from database it creates a shortcode for the client.
			This gives oportunity to copy the shortcode generated from this function and paste to their position on the page.
		*/

	function generate_shortcodes($endpoints){

		$shortcodes = array();
		if(empty($endpoints)) {
			return null;
		}
		else {	
			foreach ($endpoints as $endpoint) {
				$shortcode = '[matchunter ';
				if(strpos($endpoint, "round/list") !== false) {
					$type = "round_list";
					$tournament_id = substr($endpoint,strpos($endpoint, "round/list")+11 ,1);
					$shortcode = $shortcode."type='".$type."' "."tournament_id='".$tournament_id."'";
				}
				if(strpos($endpoint, "tournament/ranking") !== false) {
					$type ="tournament_ranking";
					$tournament_id = substr($endpoint,strpos($endpoint, "tournament/ranking")+19 ,1);
					$page = substr($endpoint,strpos($endpoint, "tournament/ranking")+21 ,1);
					$shortcode = $shortcode."type='".$type."' "."tournament_id='".$tournament_id."' "."page='".$page."'";
				}
				if(strpos($endpoint, "round/ranking") !== false) {
					$type ="round_ranking";
					$tournament_id = substr($endpoint,strpos($endpoint, "round/ranking")+14 ,1);
					$round_ranking = substr($endpoint,strpos($endpoint, "round/ranking")+16 ,1);
					$page = substr($endpoint,strpos($endpoint, "round/ranking")+18 ,1);
					$shortcode = $shortcode."type='".$type."' "."tournament_id='".$tournament_id."' "."round_number='".$round_ranking."' "."page='".$page."'";
				}
				if(strpos($endpoint, "round/matches") !== false) {
					$type ="round_matches";
					$tournament_id = substr($endpoint,strpos($endpoint, "round/matches")+14 ,1);
					$round_number =  substr($endpoint,strpos($endpoint, "round/matches")+16 ,1);
					$shortcode = $shortcode."type='".$type."' "."tournament_id='".$tournament_id."' ";
				}
				$shortcode = $shortcode . "]";
				array_push($shortcodes, $shortcode);
			}
			return $shortcodes;
		}
	}

	$descriptions = generate_descriptions($endpoints);
	$data = generate_shortcodes($endpoints);

?>
	<div class = "row"> 
		<div style="background: -webkit-linear-gradient(45deg, #09009f, #00ff95);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;float:right; margin-right:5%;">
			<h2 style="margin-left:35%; margin-top:2%;">Shortcode</h2>
			<?php
				if(empty($data)) { 
					echo '0 shortcodes were found!';
				} else {
					foreach($data as $shortcode) {
						echo '<p style="margin:5% 10% 14% 10%">'.$shortcode.'</p>';
					}
				}
			?>
		</div>
		<div class="col-6" style="background: -webkit-linear-gradient(45deg, #7b4397, #dc2430 50%);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent; margin-left:10%; margin-right: 20%">
			<h2 style="margin-top:2%;margin-left:30%">Description</h2>
			<?php 
				if(empty($descriptions)) {
					echo'Nothing to describe';
				} else { 
					foreach ($descriptions as $description) {
						echo '<p style="margin:5% 10% 8% 10%">'.$description.'</p>';
					}
				}
			?>
		</div>
	</div>
<?php
	require_once(MATCHUNTER_PATH. 'admin/partials/footer.php');
?>
