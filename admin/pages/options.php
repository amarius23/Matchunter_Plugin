<?php
		$first_text = esc_attr(get_option('api_token', ''));
		 $conn = mysqli_connect(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
            // Check connection
            if (!$conn){
              die("Connection failed: " . mysqli_connect_error());
            }
            $control = "SELECT token FROM client_token";
            $result = mysqli_query($conn, $control);
			$row = mysqli_fetch_assoc($result);


            $sql = 'CREATE TABLE IF NOT EXISTS client_token(token VARCHAR(100));';
            if(mysqli_query($conn,$sql)){
	            	if(mysqli_num_rows($result) == 0){
	            	$send = "INSERT INTO client_token(token) VALUES ('$first_text');";
	            	if (mysqli_query($conn, $send)) {
	            	echo "<p class='h5' style='float: left; color: green;'> Data has been created</p>";
	          		} else {
	            	echo "<p class='h5' style='float: left; color: green;'>Error saving data: Ktu" . mysqli_error($conn)."</p>";
	          		}
            	}
            	
            	else {
	            	$send = "UPDATE client_token SET token = '".$first_text."' ;";
	            	 if (mysqli_query($conn, $send)) {
	            	echo "<p class='h5' style='float: left; color: green;'> Data has been updated</p>";
	          		} else {
	            	echo "<p class='h5' style='float: left; color: green;'>Error saving data: Ktu" . mysqli_error($conn)."</p>";
	          		}
            	}
            }

		$client = new \GuzzleHttp\Client();
		 $response = $client->request('GET', 'http://78.46.160.168:5000/api/views/round/list/1?token='.$row['token']);
		if($response->getStatusCode() == 200){
			echo $response->getBody();
		
		}else{
			echo "An HTTP Request error happened. The HTTP status is". $response->getStatusCode();
		}
		?>