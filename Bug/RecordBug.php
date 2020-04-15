<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Bug Report</title>
	<link rel="stylesheet" type="text/css" href="php_styles.css" />  	
</head>

<body>

<?php

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('mysqli_oop_connect.php');
   
	$errors = array(); // Initialize an error array.
	

	if (empty($_POST['product'])) {
		$errors[] = 'You forgot to enter a product.';
	} else {
		$product = $mysqli->real_escape_string(trim($_POST['product']));
	}

	if (empty($_POST['product'])) {
		$errors[] = 'You forgot to enter a product.';
	} else {
		$product = $mysqli->real_escape_string(trim($_POST['product']));
	}

	if (empty($_POST['version'])) {
		$errors[] = 'You forgot to enter a version.';
	} else {
		$version = $mysqli->real_escape_string(trim($_POST['version']));
	}

	if (empty($_POST['os'])) {
		$errors[] = 'You forgot to enter an operating system.';
	} else {
		$os = $mysqli->real_escape_string(trim($_POST['os']));
	}

	if (empty($_POST['btype'])) {
		$errors[] = 'You forgot to enter a bug type.';
	} else {
		$btype = $mysqli->real_escape_string(trim($_POST['btype']));
	}				  

	if (empty($_POST['summary'])) {
		$errors[] = 'You forgot to enter a summary.';
	} else {
		$summary = $mysqli->real_escape_string(trim($_POST['summary']));
	}	
	
	if (empty($_POST['status'])) {
		$errors[] = 'You forgot to enter a status.';
	} else {
		$status = $mysqli->real_escape_string(trim($_POST['status']));
	}	
	
	if (empty($_POST['reported'])) {
		$errors[] = 'You forgot to enter who reported the bug.';
	} else {
		$reported = $mysqli->real_escape_string(trim($_POST['reported']));
	}

	if (empty($_POST['entered'])) {
		$errors[] = 'You forgot to enter the date.';
	} else {
		$entered = $mysqli->real_escape_string(trim($_POST['entered']));
	}	




if (empty($errors)) { // If everything's OK.
	

  $q = "INSERT INTO reports (product, version, os, btype, summary, status, reported, entered) VALUES ('$product', '$version', '$os', '$btype', '$summary', '$status', '$reported', '$entered')";

  $r = @$mysqli->query($q);	



// Step 5
  if ($mysqli->affected_rows == 1) {
	$BugID = $mysqli->insert_id;
	echo "<h1>Entry Saved</h1> <p>Bug report assigned an ID of $BugID.</p>";
  } 
  else {
  	  echo "<p>Unable to execute the query. Error code " . $mysqli->error ." </p> </body> </html>";
  }


} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
		
	$mysqli->close(); // Close the database connection.
	unset($mysqli);
}

?>
<p><a href="BugReport.php">Return to Bug Report</a></p>
</body>
</html>