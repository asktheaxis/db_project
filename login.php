<?php # Script 12.8 - login.php #3
// This page processes the login form submission.
// The script now uses sessions.

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('includes/login_functions.inc.php');

	$errors = [];
	if (empty($_POST['dealer_name'])) {
		$errors[] = 'You forgot to enter your dealer name.';
	} else {
		$dealer_name = $_POST['dealer_name'];
	}

	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$dealer_pass = $_POST['pass'];
	}

	if(empty($errors)) {
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

		$q = "SELECT dealer_name FROM users WHERE dealer_name='$d' AND dealer_password='$p'";
		$stmt = $conn->query($q); // Run the query.
		$check = false;

		// Check the result:
		if ($stmt) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$check = true;
		} else { 
			$errors[] = 'The dealer name and password entered do not match those on file.';
		}

		if ($check) { // OK!

		// Set the session data:
		session_start();
		$_SESSION['dealer_name'] = $row['dealer_name'];
		$_SESSION['dealer_id'] = $row['dealer_id'];

		// Redirect:
		redirect_user('Sales/sales.php');

		} else { // Unsuccessful!

			// Assign $data to $errors for login_page.inc.php:
			$errors[] = $data;

		}
	} else {
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';
	}

	$conn = NULL; // Close the database connection.

} // End of the main submit conditional.
?>
<h1>Login</h1>
<form action="login.php" method="post">
	<p>Dealer Name: <input type="text" name="dealer_name" size="15" maxlength="20" value="<?php if (isset($_POST['dealer_name'])) echo $_POST['dealer_name']; ?>"></p>
	<p>Password: <input type="password" name="pass" size="10" maxlength="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" ></p>
	<p><input type="submit" name="submit" value="Login"></p>
</form>
<?php include('includes/footer.html'); ?>