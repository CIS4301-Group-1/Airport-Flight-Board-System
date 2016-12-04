<?php session_start(); 
echo "HI";
?><!doctype html>
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

	<!-- Google+ Metadata /-->
	<meta itemprop="name" content="">
	<meta itemprop="description" content="">
	<meta itemprop="image" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

	<link rel="stylesheet" href="css/gumby.css">
	<link rel="stylesheet" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700' rel='stylesheet' type='text/css'>

	<script src="js/libs/modernizr-2.6.2.min.js"></script>
</head>

<body>

<?php include('includes/header.php'); include('includes/addproject.php'); include('includes/addtask.php'); include('includes/deletetask.php'); ?>

<div class="row">
	<div class="centered twelve columns">
		<h1 class="welcome"><?php echo $first_name; ?></h1>
	</div>
</div>

<div class="row buttons">
	<div class="six columns">
		<a href="#" class="switch" gumby-trigger="#new-project"><div class="medium-button blue"><i class="icon-plus-squared"></i> Find Flights</div></a>
	</div>
	<div class="six columns">
		<a id="manage-projects"><div class="medium-button blue">Manage Flights</div></a>
	</div>
</div>

<?php
// Check to see which of the following radio buttons were checked (if any)
$task_dp_radio_checked = $task_dp_checked = '';
$task_ip_radio_checked = $task_ip_checked = '';
$task_rp_radio_checked = $task_rp_checked = '';
$task_pr_radio_checked = $task_pr_checked = '';
if(isset($_GET['st']) && !empty($_GET['st'])) {
	if($_GET['st'] === "dp") {
		$task_dp_radio_checked = ' checked';
		$task_dp_checked = ' checked="checked"';
	} elseif($_GET['st'] === "ip") {
		$task_ip_radio_checked = ' checked';
		$task_ip_checked = ' checked="checked"';
	} elseif($_GET['st'] === "rp") {
		$task_rp_radio_checked = ' checked';
		$task_rp_checked = ' checked="checked"';
	} elseif($_GET['st'] === "pr") {
		$task_pr_radio_checked = ' checked';
		$task_pr_checked = ' checked="checked"';
	}
}
// (Again) Check to see which of the following radio buttons were checked (if any)
$project_az_radio_checked = $project_az_checked = '';
$project_za_radio_checked = $project_za_checked = '';
$project_rp_radio_checked = $project_rp_checked = '';
$project_pr_radio_checked = $project_pr_checked = '';
if(isset($_GET['sp']) && !empty($_GET['sp'])) {
	if($_GET['sp'] === "az") {
		$project_az_radio_checked = ' checked';
		$project_az_checked = ' checked="checked"';
	} elseif($_GET['sp'] === "za") {
		$project_za_radio_checked = ' checked';
		$project_za_checked = ' checked="checked"';
	} elseif($_GET['sp'] === "rp") {
		$project_rp_radio_checked = ' checked';
		$project_rp_checked = ' checked="checked"';
	} elseif($_GET['sp'] === "pr") {
		$project_pr_radio_checked = ' checked';
		$project_pr_checked = ' checked="checked"';
	}
}
?>

<div class="manage-options">
	<div class="row">
		<div class="four columns">
			<h3>Order Tasks By</h3>
			<form id="sort-tasks" action="" method="get">
				<div class="field">
					<label class="radio<?php echo $task_dp_radio_checked; ?>" for="radio1">
						<input name="st" id="radio1" value="dp" type="radio"<?php echo $task_dp_checked; ?>>
						<span></span> Decreasing Priority (High - Low)
					</label>
					<label class="radio<?php echo $task_ip_radio_checked; ?>" for="radio2">
						<input name="st" id="radio2" value="ip" type="radio"<?php echo $task_ip_checked; ?>>
						<span></span> Increasing Priority (Low - High)
					</label>
					<label class="radio<?php echo $task_rp_radio_checked; ?>" for="radio3">
						<input name="st" id="radio3" value="rp" type="radio"<?php echo $task_rp_checked; ?>>
						<span></span> Date Added (Recent - Past)
					</label>
					<label class="radio<?php echo $task_pr_radio_checked; ?>" for="radio4">
						<input name="st" id="radio4" value="pr" type="radio"<?php echo $task_pr_checked; ?>>
						<span></span> Date Added (Past - Recent)
					</label>
				</div>
				<?php
					// Keep the previously inputted $_GET parameters, except for $_GET['st'] as that is what we are looking to change
					foreach($_GET as $name => $value) {
						$name = htmlspecialchars($name);
						$value = htmlspecialchars($value);
						if($name !== "st") {
							echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
						}
					}
				?>
				<div class="field">
					<div class="small-button green">
						<input type="submit" value="Update"/>
					</div>
				</div>
			</form>
		</div>
		<div class="four columns">
			<h3>Order Projects By</h3>
			<form id="sort-projects" action="" method="get">
				<div class="field">
					<label class="radio<?php echo $project_az_radio_checked; ?>" for="radio1">
						<input name="sp" id="radio1" value="az" type="radio"<?php echo $project_az_checked; ?>>
						<span></span> Project Title (A - Z)
					</label>
					<label class="radio<?php echo $project_za_radio_checked; ?>" for="radio2">
						<input name="sp" id="radio2" value="za" type="radio"<?php echo $project_za_checked; ?>>
						<span></span> Project Title (Z - A)
					</label>
					<label class="radio<?php echo $project_rp_radio_checked; ?>" for="radio3">
						<input name="sp" id="radio3" value="rp" type="radio"<?php echo $project_rp_checked; ?>>
						<span></span> Date Added (Recent - Past)
					</label>
					<label class="radio<?php echo $project_pr_radio_checked; ?>" for="radio4">
						<input name="sp" id="radio4" value="pr" type="radio"<?php echo $project_pr_checked; ?>>
						<span></span> Date Added (Past - Recent)
					</label>
				</div>
				<?php
					// Keep the previously inputted $_GET parameters, except for $_GET['sp'] as that is what we are looking to change
					foreach($_GET as $name => $value) {
						$name = htmlspecialchars($name);
						$value = htmlspecialchars($value);
						if($name !== "sp") {
							echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
						}
					}
				?>
				<div class="field">
					<div class="small-button green">
						<input type="submit" value="Update"/>
					</div>
				</div>
			</form>
		</div>
		<div class="four columns">
			<h3>Options</h3>
			<p><a id="satd">Hide/Show All Task Details</a></p>
		</div>
	</div>
</div>

<?php
	require_once('includes/mysqli_connect.php');
	
	$p = "SELECT ... FROM ... WHERE ... AND ... ORDER BY ...";
	$p_r = @mysqli_query($mysqli, $p);
	if(@mysqli_num_rows($p_r) == 0) {
		echo '<div class="row"><div class="centered twelve columns"><p>No records found!</p></div></div>';
	} else {
		$index = 0;
		while($current_project = @mysqli_fetch_assoc($p_r)) {
			
			// Pull each record one at a time
			
		}
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
	<script src="js/db.js"></script>
	<script src="js/ga.js"></script>

  </body>
</html>
