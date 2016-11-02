<?php session_start(); 

if(!isset($_SESSION['user_id'])) {
	$url = "index";
	ob_end_clean(); 
	header("Location: $url");
	exit();
} else {
	$user_id = abs((int)$_SESSION['user_id']);
}

?><!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>View Project - NoteCheck</title>

	<meta name="robots" content="noindex">
	<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<link rel="stylesheet" href="css/gumby.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700' rel='stylesheet' type='text/css'>

	<script src="js/libs/modernizr-2.6.2.min.js"></script>
</head>

<body id="my-account">

<?php include('includes/header.php'); include('includes/membershipdetails.php'); require_once('includes/mysqli_connect.php');

$content = $no_fn = $no_ln = $no_un = $no_e = $no_c = $f = $l = $u = $e = $c = '';
$message = $interchange = FALSE;

// Get the user's details
$qe = "SELECT email_address, username, first_name, last_name, company_name, email_verification, membership_id FROM users WHERE user_id='$user_id'";
$re = @mysqli_query($mysqli, $qe);
$ie = @mysqli_fetch_assoc($re);

$f = $ie['first_name'];
$l = $ie['last_name'];
$u = $ie['username'];
$e = $previous_email = $ie['email_address'];
$c = $ie['company_name'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need the database connection
	require_once('includes/mysqli_connect.php');

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	$fn = $ln = $un = $em = $co = FALSE;

	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['first_name'])) {
		$fn = @mysqli_real_escape_string($mysqli, $trimmed['first_name']);
	} else {
		$no_fn = '<div class="danger alert">Please enter a valid first name.</div>';
	}

	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = @mysqli_real_escape_string($mysqli, $trimmed['last_name']);
	} else {
		$no_ln = '<div class="danger alert">Please enter a valid last name.</div>';
	}

	// Check for a username
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['username'])) {
		$un = @mysqli_real_escape_string($mysqli, $trimmed['username']);
	} else {
		$no_un = '<div class="danger alert">Please enter a valid username</div>';
	}

	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$em = @mysqli_real_escape_string($mysqli, $trimmed['email']);
	} else {
		$no_e = '<div class="danger alert">Please enter a valid email address.</div>';
	}

	if(isset($trimmed['company']) && !empty($trimmed['company'])) {
		$co = @mysqli_real_escape_string($mysqli, $trimmed['company']);
	} else {
		$no_c = '<div class="danger alert">Please enter a valid company name.</div>';
	}

	if($fn) {
		$f = $fn;
	}
	
	if($ln) {
		$l = $ln;
	}

	if($un) {
		$u = $un;
	}
	
	if($em) {
		$e = $em;
	}
	
	if($co) {
		$c = $co;
	}

	if($fn && $ln && $un && $em && $c) {

		$q = "UPDATE users SET first_name='$fn', last_name='$ln', username='$un', email_address='$em', company_name='$co' WHERE user_id='$user_id'";
		@mysqli_query($mysqli, $q);

		if(@mysqli_affected_rows($mysqli) == 0) {
			$message = '<div id="mn-nu" class="info-box"><div class="row"><div class="push_eleven one column"><i class="icon-cancel" data-mn="nu"></i></div><div class="pull_one eleven columns"><p>You didn\'t change anything!</p></div></div></div>';
		} elseif(@mysqli_affected_rows($mysqli) > 0) {
			$message = '<div id="mn-sac" class="success-box"><div class="row"><div class="push_eleven one column"><i class="icon-cancel" data-mn="sac"></i></div><div class="pull_one eleven columns"><p>Your account details have been updated.</p></div></div></div>';
		} else {
			$message = '<div id="mn-sac" class="success-box"><div class="row"><div class="push_eleven one column"><i class="icon-cancel" data-mn="sac"></i></div><div class="pull_one eleven columns"><p>Your account details have been updated.</p></div></div></div>';
		}
		
		if($e !== $previous_email) {

			$code = md5(uniqid(rand(), true));

			$q_e = "UPDATE users SET email_verification='$code' WHERE user_id='$user_id'";
			@mysqli_query($mysqli, $q_e);

			if(@mysqli_affected_rows($mysqli) == 1) {

				// Send out a new verification email
				include('includes/emails/new_email_verification.php');

				if(getEmail($em, $fn, $ln, $code)) {
					$message .= '<div id="mn-seu" class="success-box" style="border-top: 1px solid #fff;"><div class="row"><div class="push_eleven one column"><i class="icon-cancel" data-mn="seu"></i></div><div class="pull_one eleven columns"><p>We have sent a verification link to your new email address. Please click it to verify your email address works.</p></div></div></div>';
				} else {
					$message .= '<div id="mn-ueu" class="info-box" style="border-top: 1px solid #fff;"><div class="row"><div class="push_eleven one column"><i class="icon-cancel" data-mn="ueu"></i></div><div class="pull_one eleven columns"><p>We have updated your email address, but were unable to send you a verification link. Please <a href="mailto:support@notecheck.com" title="Contact the NoteCheck Support Team">contact support</a> with your new email address so that we can verify it works.</p></div></div></div>';
				}

			} else {
				$message .= '<div id="mn-ueu" class="error-box"><div class="row"><div class="push_eleven one column"><i class="icon-cancel" data-mn="ueu"></i></div><div class="pull_one eleven columns"><p>You changed your email address, but we were unable to update it. Please try again, and <a href="mailto:support@notecheck.com" title="Contact the NoteCheck Support Team">contact support</a> if this error continues.</p></div></div></div>';
			}

		}

	} else {

		$interchange = ' class="swap"';

	}

	//  if the email has been changed..
		// mark verified_email as 0
		// send the user an email to verify the new email address 

	// Update all fields

}

	if(@mysqli_num_rows($re) == 0) {
		$content .= '';
	} else {
		$user_details = @mysqli_fetch_assoc($re);
	
		$content .= '<h1>My Account</h1><div class="breaker"></div>';
		
		$content .= '<form id="sd"' . $interchange . ' action="" method="post">';
		
		// First and Last Name Display
		$content .= '<div id="n1" class="row"><div class="four columns"><h4>Your Name</h4></div><div class="eight columns"><p>' . $f . ' ' . $user_details['last_name'] . '</p></div></div>';
		// First and Last Name Input
		$content .= '<div id="n2" class="row"><div class="four columns"><h4>Your Name</h4></div><div class="four columns">' . $no_fn . '<p class="field"><input type="text" class="input" name="first_name" value="' . $f . '"/></p></div><div class="four columns">' . $no_ln . '<p class="field"><input type="text" class="input" name="last_name" value="' . $l . '"/></p></div></div>';

		// Username Display
		$content .= '<div id="u1" class="row"><div class="four columns"><h4>Username</h4></div><div class="eight columns"><p>' . $u . '</p></div></div>';
		// Username Input
		$content .= '<div id="u2" class="row"><div class="four columns"><h4>Username</h4></div><div class="eight columns">' . $no_un . '<p class="field"><input type="text" class="input" name="username" value="' .$u . '"/></p></div></div>';

		// Email Address Display
		$content .= '<div id="e1" class="row"><div class="four columns"><h4>Email Address</h4></div><div class="eight columns"><p>' . $e . '</p></div></div>';
		// Email Address Input
		$content .= '<div id="e2" class="row"><div class="four columns"><h4>Email Address</h4></div><div class="eight columns">' . $no_e . '<p class="field"><input type="email" class="input" name="email" value="' . $e . '"/></p></div></div>';
		
		// Company Name Display
		$content .= '<div id="c1" class="row"><div class="four columns"><h4>Company Name</h4></div><div class="eight columns"><p>' . $c . '</p></div></div>';
		// Company Name Input
		$content .= '<div id="c2" class="row"><div class="four columns"><h4>Company Name</h4></div><div class="eight columns">' . $no_c . '<p class="field"><input type="text" class="input" name="company" value="' . $c . '"/></p></div></div>';

		if($user_details['membership_id'] != 0) {
			$membership_level_text = 'Inactive';
		} else {
			$m = "SELECT membership_level, membership_active FROM memberships WHERE membership_id='" . $user_details['membership_id'] . "'";
			$r_m = @mysqli_query($mysqli, $m);
			$membership_details = @mysqli_fetch_assoc($r_m);
			$membership_level = $membership_details['membership_level'];
			$membership_active = $membership_details['membership_active'];
			
			if($membership_level === 0) {
				$membership_level_text = 'Inactive';
			} elseif($membership_level === 1) {
				$membership_level_text = 'Free';
			} elseif($membership_level === 2) {
				$membership_level_text = 'Personal';
			} elseif($membership_level === 3) {
				$membership_level_text = 'Business';
			} else {
				$membership_level_text = 'Inactive';
			}
		}

		$content .= '<div class="row"><div class="four columns"><h4>Membership</h4></div><div class="eight columns"><p><a href="#" class="switch" gumby-trigger="#membership-details">' . $membership_level_text . '</a></p></div></div>';

		$content .= '<div id="i1" class="row"><div class="centered twelve columns"><p><span class="bold">Note</span>: If you change your email address, you must verify it before you are allowed to use it.</br>In the meantime, you may still use your username to log in.</p></div></div>';

		$content .= '<div id="b1" class="row buttons"><div class="centered four columns"><a id="edit-details"><div class="small-button">Edit</div></a></div></div>';

		$content .= '<div id="b2" class="row buttons"><div class="six columns"><a id="save-details"><div class="small-button green">Update</div></a></div><div class="six columns"><a id="cancel-details"><div class="small-button red">Cancel</div></a></div></div>';

		$content .= '</form>';

	}

?>

<?php if($message) {echo $message;} ?>

<div class="row">
	<div class="centered twelve columns">
		<div class="project-pages">
			<div class="page">
				<?php
					echo $content;
				?>
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
