<?php session_start(); ?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Verify Your Email Address</title>

	<meta name="robots" content="noindex">
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<link rel="stylesheet" href="css/gumby.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700' rel='stylesheet' type='text/css'>

	<script src="js/libs/modernizr-2.6.2.min.js"></script>
</head>

<body id="verify-email">

<?php include('includes/header.php');

if (isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y']) == 32 )) {

	require('includes/mysqli_connect.php');

	$email = @mysqli_real_escape_string($mysqli, $_GET['x']);
	$code = @mysqli_real_escape_string($mysqli, $_GET['y']);

	$qs = "SELECT user_id FROM users WHERE email_verification IS NULL AND email_address='$email'";
	$rs = @mysqli_query($mysqli, $qs);

	if(@mysqli_num_rows($rs) == 0) {

		$qu = "UPDATE users SET email_verification=NULL WHERE (email_address='$email' AND email_verification='$code') LIMIT 1";
		@mysqli_query($mysqli, $qu);

		if (@mysqli_affected_rows($mysqli) == 1) {

			@mysqli_free_result($rs);
			@mysqli_close($mysqli);

			// The update/email verification was successful
			$url = "success?m=sev";
			ob_end_clean();
			header("Location: $url");
			exit();

		} else {

			@mysqli_free_result($rs);
			@mysqli_close($mysqli);

			// The update/email verification was unsuccessful
			$url = "error?m=uev";
			ob_end_clean();
			header("Location: $url");
			exit();

		}

	} elseif(@mysqli_num_rows($rs) == 1) {

		@mysqli_free_result($rs);
		@mysqli_close($mysqli);

		// This user's email has already been validated
		$url = "success?m=sev2";
		ob_end_clean();
		header("Location: $url");
		exit();

	} else {

		@mysqli_free_result($rs);
		@mysqli_close($mysqli);

		// The update/email verification was unsuccessful
		$url = "error?m=uev";
		ob_end_clean();
		header("Location: $url");
		exit();

	}

} else {

	$url = "dashboard";
	ob_end_clean();
	header("Location: $url");
	exit();

}

?>

	<script>
	var oldieCheck = Boolean(document.getElementsByTagName('html')[0].className.match(/\soldie\s/g));
	if(!oldieCheck) {
	document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"><\/script>');
	} else {
	document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>');
	}
	</script>
	<script>
	if(!window.jQuery) {
	if(!oldieCheck) {
	  document.write('<script src="js/libs/jquery-2.0.2.min.js"><\/script>');
	} else {
	  document.write('<script src="js/libs/jquery-1.10.1.min.js"><\/script>');
	}
	}
	</script>

	<script src="js/gumby.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
	<?php
		if($interchange) {
			echo '<script src="js/ma-i.js"></script>';
		} else {
		 	echo '<script src="js/ma.js"></script>';
		}
	?>
	<script src="js/ga.js"></script>

  </body>
</html>
