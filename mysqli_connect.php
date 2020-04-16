<?php

// This file contains the database access information.
// This file also establishes a connection to Oracle


// Make the connection:
$dbc = "(DESCRIPTION =
  (ADDRESS = (PROTOCOL = TCP)(HOST =  CITDB.NKU.EDU)(PORT = 1521))
  (CONNECT_DATA = (SERVER = DEDICATED)(SERVICE NAME = csc450.citdb.nku.edu)))";
$db_user = "chrystala1";
$db_password = "csc616";
try {
	$conn = new PDO("oci:dbname=".$dbc,$db_user,$db_password);
	echo 'Successfully connected to Oracle';
} catch(PDOException $e) {
	echo ($e->getMessage());
}