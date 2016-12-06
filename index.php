#!/usr/local/bin/php
<?php session_start(); ?><!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Airport Flight Board System</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="author" content="humans.txt">

	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

	<!-- Facebook Metadata /-->
	<meta property="fb:page_id" content="" />
	<meta property="og:image" content="" />
	<meta property="og:description" content=""/>
	<meta property="og:title" content=""/>

	<!-- Google+ Metadata /-->
	<meta itemprop="name" content="">
	<meta itemprop="description" content="">
	<meta itemprop="image" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<link rel="stylesheet" href="css/gumby.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/index.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700' rel='stylesheet' type='text/css'>

	<script src="js/libs/modernizr-2.6.2.min.js"></script>
</head>

<body>

<?php

//ini_set('display_errors', 1);
//error_reporting(E_ALL ^ E_NOTICE);

$m_u = $m_p = $u_l = FALSE;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Include the oracle connection file
	require('includes/oracle_connect.php');

	// Assume false values
	$u = $p = FALSE;

	// Validate the username or email address:
	if (isset($_POST['eou']) && !empty($_POST['eou'])) {
		//$u = @mysqli_real_escape_string ($oracle_connection, $_POST['eou']);
		$u = $_POST['eou'];
	} else {
		$m_u = TRUE; // "m_u" stands for missing_username
	}

	// Validate the password:
	if (isset($_POST['pas']) && !empty($_POST['pas'])) {
		//$p = @mysqli_real_escape_string ($oracle_connection, $_POST['pas']);
		$p = $_POST['pas'];
	} else {
		$m_p = TRUE; // "m_p" stands for missing_password
	}

	// If user entered username and password
	if($u && $p) {

		// Query users
		//$q_u = "SELECT user_id, first_name, last_name FROM users WHERE username='$u' AND password=SHA1('$p')";
		$q_u = oci_parse($oracle_connection, "SELECT password FROM users where username=$u");
		//$r_u = @mysqli_query($oracle_connection, $q_u);
		$r_u = oci_execute($q_u);

		//$q_e = "SELECT user_id, first_name, last_name FROM users WHERE email_address='$u' AND password=SHA1('$p')";
		//$r_e = @mysqli_query($oracle_connection, $q_e);
		//$r_e = @oci_execute(oci_parse($oracle_connection, $q_e);

		// Successful login with the username
		if(@oci_num_rows($r_u) == 1) {

			$_SESSION = @oci_fetch_assoc($r_u); 
			@oci_free_statement($r_u);
			@oci_free_statement($r_e);
			@oci_close($oracle_connection);

			$url = "dashboard";
			ob_end_clean(); 
			header("Location: $url");
			exit();

		// Successful login with the email address
		} else {

			$u_l = TRUE; // "u_l" stands for unsuccessful_login

		}

	}

}

?>

<div class="row">
	<div class="centered twelve columns">
		<div class="logo-container">
			<img src="img/nc_s.png" gumby-retina="" title="NoteCheck"/>
		</div>
		<div class="row">
			<div class="centered eight columns">
				<div class="landing-box">
					<h2>Sign into your account.</h2>
					<?php if($u_l) { echo '<div class="danger alert">Your username/email and password combination is not valid. Please try again.</div>'; } ?>
					<form id="process" action="" method="post">
						<div class="field">
							<?php if($m_u) { echo '<div class="danger alert">You forgot to enter your username or email address.</div>'; } ?>
							<input type="text" class="input" name="eou" placeholder="Email or Username" autocomplete="off"/>
						</div>
						<div class="field">
							<?php if($m_p) { echo '<div class="danger alert">You forgot to enter your password.</div>'; } ?>
							<input type="password" class="input" name="pas" placeholder="Password" autocomplete="off"/>
						</div>
						<div class="field">
							<div class="medium-button green">
								<input type="submit" value="Sign In"/>
							</div>
						</div>
					</form>
					<h3>Looking to sign up for an account? <a href="createAccount.php">Sign up here</a>.</h3>
				</div>
			</div>
		</div>
	</div>
</div>

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
	  document.write('<script src="/cise/homes/ctf/public_html/CIS4301/js/libs/jquery-2.0.2.min.js"><\/script>');
	} else {
	  document.write('<script src="/cise/homes/ctf/public_html/CIS4301/js/libs/jquery-1.10.1.min.js"><\/script>');
	}
	}
	</script>

	<script src="js/gumby.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>

  </body>
</html>
