<?php # Script 9.2 - mysqli_connect.php

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

// Set the database access information as constants:
define('DB_USER', 'chrystala1');
define('DB_PASSWORD', 'df9010ee');
define('DB_HOST', 'csweb.hh.nku.edu');
define('DB_NAME', 'db_fall19_chrystala1');

// Make the connection:
$mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


// Verify the connection:
if ($mysqli->connect_error) {
   echo $mysqli->connect_error;
   unset($mysqli);
} else {
    $mysqli->set_charset('utf8');
}