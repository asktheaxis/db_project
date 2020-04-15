<?php # Script 12.2 - login_functions.inc.php
// This page defines two functions used by the login/logout process.

/* This function determines an absolute URL and redirects the user there.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */
function redirect_user($page = 'login.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');

	// Add the page:
	$url .= '/' . $page;

	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.

function redirect_user_bug($page = '../login.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');

	// Add the page:
	$url .= '/' . $page;

	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

}


/* This function validates the form data (the dealer name and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 * - a TRUE/FALSE variable indicating success
 * - an array of either errors or the database result
 */
function check_login($dbc, $dealer_id = '', $pass = '') {

	$errors = []; // Initialize error array.

	// Validate the dealer's name:
	if (empty($dealer_name)) {
		$errors[] = 'You forgot to enter your dealer name.';
	} else {
		$d = mysqli_real_escape_string($dbc, trim($dealer_name));
	}

	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		// Retrieve the user_id and first_name for that dealer name/password combination:
		$q = "SELECT dealer_name FROM users WHERE dealer_name='$d' AND pass=SHA2('$p', 512)";
		$r = @mysqli_query($dbc, $q); // Run the query.

		// Check the result:
		if (mysqli_num_rows($r) == 1) {

			// Fetch the record:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			// Return true and the record:
			return [true, $row];

		} else { // Not a match!
			$errors[] = 'The dealer name and password entered do not match those on file.';
		}

	} // End of empty($errors) IF.

	// Return false and the errors:
	return [false, $errors];

} // End of check_login() function.