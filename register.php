<?php
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register';
include('includes/header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = []; // Initialize an error array.
	$passPattern = '/[0-9]+[A-Z]+[a-z]+/';

	// Check for dealer's name:
	if (empty($_POST['dealer_name'])) {
		$errors[] = 'You forgot to enter your dealer name.';
	} else {
		$dn = $_POST['dealer_name'];
	}

	// Check for a password and match against the confirmed password:
	if (strlen($_POST['pass1']) > 7 && preg_match($passPattern, $_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = $_POST['pass1'];
		}
	} else {
		$errors[] = 'Please enter a valid password; it must be 8 characters, have 1 digits, 1 uppercase letter and 1 lower case letter';
	}

	if (empty($errors)) { // If everything's OK.
	
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

		// Get the dealer's id
		$q1 = "SELECT dealer_id from dealer WHERE name= '$dn'";
		$stmt = $conn->query($q1);
		if($stmt === false) {
			die("Error executing the query");
		}
		$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = (int) $row1['DEALER_ID'];
		$dealer_id = sprintf("%'03d", $id);

		// insert dealer into users
		$q = "insert into users values('$dealer_id', '$dn', '$p')";
		$r = $conn->query($q);
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
			<p>You are now registered.</p><p><br></p>';

		} else { // If it did not run OK.

			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			die("Error executing the query");

		}

		$conn = NULL; // Close the database connection.

		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} 

	$conn = NULL; // Close the database connection.

} // End of the main Submit conditional.
?>
<h1>Register</h1>
<form action="register.php" method="post">
	<p>Dealer Name: <input type="text" name="dealer_name" size="15" maxlength="20" value="<?php if (isset($_POST['dealer_name'])) echo $_POST['dealer_name']; ?>"></p>
	<p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" ></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p><input type="submit" name="submit" value="Register"></p>
</form>
<?php include('includes/footer.html'); ?>