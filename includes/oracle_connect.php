
<?php

$connection = oci_connect($username = 'asoliman',
                          $password = 'password',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$statement = oci_parse($connection, 'SELECT * FROM users');
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
oci_close($connection);
?>
