<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sales Report</title>
	<link rel="stylesheet" type="text/css" href="php_styles.css" />  	
</head>

<body>

<?php

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$tns = "  
		(DESCRIPTION =
			(ADDRESS = (PROTOCOL = TCP)(HOST = CITDB.NKU.EDU)(PORT = 1521))
			(CONNECT_DATA =
				(SERVER = DEDICATED)
				(SERVICE_NAME = csc450.citdb.nku.edu)    
			)
		)";
		$db_user = "chrystala1";
		$db_password = "csc616";
		try {
			$conn = new PDO("oci:dbname=".$tns,$db_user,$db_password);
			echo 'Successfully connected to Oracle';
		} catch(PDOException $e) {
			echo ($e->getMessage());
		}
   
	$errors = array(); // Initialize an error array.
	

	if (empty($_POST['vin'])) {
		$errors[] = 'You forgot to enter a vin.';
	} else {
		$vin = $_POST['vin'];
	}

	if (empty($_POST['dealer_id'])) {
		$errors[] = 'You forgot to enter a dealer id.';
	} else {
		$dealer_id = $_POST['dealer_id'];
	}

	if (empty($_POST['cust_id'])) {
		$errors[] = 'You forgot to enter a customer id.';
	} else {
		$cust_id = $_POST['cust_id'];
	}

	if (empty($_POST['sale_price'])) {
		$errors[] = 'You forgot to enter an sale price.';
	} else {
		$sale_price = $_POST['sale_price'];
	}

	if (empty($_POST['sale_date'])) {
		$errors[] = 'You forgot to enter a sale date.';
	} else {
		$sale_date = trim($_POST['sale_date'];
	}				  	


if (empty($errors)) { // If everything's OK.
	

  $q = "insert into sells values('$vin', '$dealer_id', '$cust_id', '$sale_price', '$sale_date')";

  $r = $conn->query($q);	
  $count = $r->rowCount();
  

  if ($count == 1) {
	echo "<h1>Entry Saved</h1>";
  } 
  else {
  	  echo "<p>Unable to execute the query.</p> </body> </html>";
  }


} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
		
	$conn = NULL; // Close the database connection.
}

?>
<p><a href="sales.php">Return to Sales Reports</a></p>
</body>
</html>