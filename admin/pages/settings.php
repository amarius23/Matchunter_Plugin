<?php
$title = "Settings";

require_once( MATCHUNTER_PATH . 'admin/partials/header.php');
?>

<?php settings_errors();?>
<form method="POST" action="options.php" >
	<?php settings_fields('mh-settings-page');?>
	<?php do_settings_sections('mh-settings-page')?>
	<?php $first_text = esc_attr(get_option('api_token', ''));
		 $conn = mysqli_connect(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
            // Check connection
            if (!$conn){
              die("Connection failed: " . mysqli_connect_error());
            }
        	$control = "SELECT token FROM matchunter_client_token";
        	$result = mysqli_query($conn, $control);	
            $sql = 'CREATE TABLE IF NOT EXISTS matchunter_client_token(token VARCHAR(100));';
            if(mysqli_query($conn,$sql)){
	            if(mysqli_num_rows($result) == 0){ $send = "INSERT INTO matchunter_client_token(token) VALUES ('$first_text');";
            	}
            	else $send = "UPDATE matchunter_client_token SET token = '".$first_text."' ;";
            }
                if (mysqli_query($conn, $send)) {
      echo "<p class='h5' style='float: right; color: green;'> Data has been saved successfully</p>";
    } else {
        echo "<p class='h5' style='float: right; color: red;'>Error saving data:" . mysqli_error($conn)."</p>";
    }
	?>
	<input type="submit" name="Submit" class="button button-primary"  value="Save Changes" >

</form>

<?php require_once( MATCHUNTER_PATH . 'admin/partials/footer.php'); ?>

