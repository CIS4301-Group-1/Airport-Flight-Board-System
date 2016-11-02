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
	<meta name="robots" content="noindex">

	<title>Success!</title>

	<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<link rel="stylesheet" href="css/gumby.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700' rel='stylesheet' type='text/css'>

	<script src="js/libs/modernizr-2.6.2.min.js"></script>

</head>

<body id="success">

<?php include('includes/header.php');

$content = "";

if(isset($_GET['m'])) {

	if($_GET['m'] === "sev") {

		$content .= '<div class="page-space"></div>';
		$content .= '<h3><i class="icon-check check"></i> Your email address has been verified.</h3>';
		$content .= '<h4>You can now log in and receive account information </br>(such as a reset password) with your email address.</h4>';
		$content .= '<div class="row"><div class="centered four columns"><div class="text-center"><a href="dashboard" title="Return to Your Dashboard"><div class="medium-button blue">Return to Dashboard</div></a></div></div></div>';
		$content .= '<div class="page-space"></div>';

	} elseif($_GET['m'] === "sev2") {

		$content .= '<div class="page-space"></div>';
		$content .= '<h3><i class="icon-check check"></i> Your email address has already been verified.</h3>';
		$content .= '<h4>You can already log in and receive account information </br>(such as a reset password) with your email address.</h4>';
		$content .= '<div class="row"><div class="centered four columns"><div class="text-center"><a href="dashboard" title="Return to Your Dashboard"><div class="medium-button blue">Return to Dashboard</div></a></div></div></div>';
		$content .= '<div class="page-space"></div>';
	
	} elseif($_GET['m'] === "WHATEVER") {
	
		$content .= 'CONTENT APPENDED TO WHAT WAS PREVIOUSLY IN CONTENT';
		
	} else {

		$url = "dashboard";
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

<div class="row">
	<div class="centered twelve columns">
		<div class="salesfeed">
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

	<script src="js/libs/gumby.min.js"></script>
	<script src="js/plugins.js"></script>
	<script src="js/main.js"></script>
	<script src="js/ga.js"></script>

  </body>
</html>