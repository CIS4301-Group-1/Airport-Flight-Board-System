#!/usr/local/bin/php
<?php

$oracle_connection = oci_connect($username = 'ctf',
                          $password = 'PASSWORD',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');

if (!$oracle_connection) {
	$oci_error_msg = oci_error();
	trigger_error(htmlentities($oci_error_msg['message'], ENT_QUOTES), E_USER_ERROR);
	unset($oracle_connection);
}// else {
//	echo 'connection good!';
//}

/**
// Verify the connection:
if ($oracle_connection->connect_error) {
	//echo $mysqli->connect_error;
	unset($oracle_connection);
} else {
	$oracle_connection->set_charset('utf8');
}


$statement = oci_parse($oracle_connection, 'SELECT * FROM users');
oci_execute($statement);

$rows = array();
while($r = oci_fetch_assoc($statement)) {
	var_dump($r);
	//$rows[] = $r;
}

//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($oracle_connection);

**/
?>
