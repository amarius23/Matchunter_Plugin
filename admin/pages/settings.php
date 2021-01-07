<?php
  $title = "Settings";

  require_once( MATCHUNTER_PATH . 'admin/partials/header.php');
?>

<?php settings_errors();?>
<?php
  $first_text = esc_attr(get_option('api_token', ''));
  if (!preg_match('/[^A-Za-z0-9]/', $first_text)){
    $conn = mysqli_connect(DB_HOST, DB_USER,DB_PASSWORD, DB_NAME);
    // Check connection
    if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
    }
    $control = "SELECT token FROM matchunter_client_token";
    $result = mysqli_query($conn, $control);
    $sql = 'CREATE TABLE IF NOT EXISTS matchunter_client_token(token VARCHAR(100));';
    if(mysqli_query($conn,$sql)) {
      $send = "UPDATE matchunter_client_token SET token = '".$first_text."' ;";
    }
    mysqli_query($conn, $send);
  }
	?>
<form method="POST" action="options.php" >
	<?php settings_fields('mh-settings-page');?>
  <?php do_settings_sections('mh-settings-page');?>
	<input type="submit" name="Submit" class="button button-primary"  value="Save Changes" >
</form>

<?php require_once( MATCHUNTER_PATH . 'admin/partials/footer.php'); ?>

