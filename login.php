#!/usr/local/bin/php

<?php

$loginuname = $_GET["username"];
$loginpasswd= $_GET["password"];

$connection = oci_connect($username = 'asoliman',
                          $password = 'Work2hard',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$statement = oci_parse($connection, "SELECT password FROM users where username='$loginuname'");
oci_execute($statement);

$results = array();
while($r = oci_fetch_assoc($statement)) {
	$results[] = $r;
}

if(count($results) > 0 && $_SESSION["password"] = $loginpasswd){
	session_start();
	echo "LOGGED IN as $loginuname";
	require('dashboard.php');
}
else{
	echo "LOGIN FAILED";
}
 
//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($connection);

?>
