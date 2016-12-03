#!/usr/local/bin/php

<?php session_start(); ?><!DOCTYPE html>
<html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product">
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>Airport Flight Board - Login</title>
	<meta name="description" content="DESC" />
	<meta name="keywords" content="KEYWRD" />
	
</head>

<body>

<form>
Username:<br>
<input type="text" name="username"><br>
Password:<br>
<input type="text" name="password"><br>
</form>



<?php

require('includes/mysqli_connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$m_u = $m_p = $u_l = FALSE;

	// Assume false values
	$u = $p = FALSE;

	// Validate the username or email address:
	if (isset($_POST['eou']) && !empty($_POST['eou'])) {
		$u = @mysqli_real_escape_string ($mysqli, $_POST['eou']);
	} else {
		$m_u = TRUE; // "m_u" stands for missing_username
	}

	// Validate the password:
	if (isset($_POST['pas']) && !empty($_POST['pas'])) {
		$p = @mysqli_real_escape_string ($mysqli, $_POST['pas']);
	} else {
		$m_p = TRUE; // "m_p" stands for missing_password
	}

	if($u && $p) {

		$q_u = "SELECT user_id, first_name, last_name FROM users WHERE username='$u' AND password=SHA1('$p')";
		$r_u = @mysqli_query($mysqli, $q_u);

		$q_e = "SELECT user_id, first_name, last_name FROM users WHERE email_address='$u' AND password=SHA1('$p')";
		$r_e = @mysqli_query($mysqli, $q_e);

		// Successful login with the username
		if(@mysqli_num_rows($r_u) == 1) {

			$_SESSION = @mysqli_fetch_assoc($r_u); 
			@mysqli_free_result($r_u);
			@mysqli_free_result($r_e);
			@mysqli_close($mysqli);

			$url = "dashboard";
			ob_end_clean(); 
			header("Location: $url");
			exit();

		// Successful login with the email address
		} elseif(@mysqli_num_rows($r_e) == 1) {

			$_SESSION = @mysqli_fetch_assoc($r_e); 
			@mysqli_free_result($r_u);
			@mysqli_free_result($r_e);
			@mysqli_close($mysqli);

			$url = "dashboard";
			ob_end_clean(); 
			header("Location: $url");
			exit();

		// Unsuccessful login with either the username or the email address
		} else {

			$u_l = TRUE; // "u_l" stands for unsuccessful_login

		}

	}

}
?>



  </body>
</html>
