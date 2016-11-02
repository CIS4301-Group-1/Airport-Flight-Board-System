<?php

if(isset($_GET['signout']) && ($_GET['signout'] === "y")) {

	session_unset();
	session_destroy();
	$_SESSION = array();
	setcookie (session_name(), '', time()-3600);
	$url = "index";
	ob_end_clean();
	header("Location: $url");
	exit();

} elseif(isset($_SESSION['first_name'])) {

	$first_name = 'Welcome, ' . $_SESSION['first_name'] . '';

} else {

	$first_name = 'Welcome';

}

?>

<div class="navbar" id="nav1">
	<div class="row">
		<a class="toggle" gumby-trigger="#nav1 > .row > ul" href="#"><i class="icon-menu"></i></a>
		<h1 class="four columns logo"><a href="dashboard"><img src="img/logo.png" gumby-retina="" title="Airport Flight Board System"/></a></h1>
		<ul class="eight columns">
			<li><a href="myaccount">My Account</a></li>
			<li><a href="?signout=y">Sign Out</a></li>
		</ul>
	</div>
</div>

