<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Bug Report</title>
	<link rel="stylesheet" type="text/css" href="php_styles.css">  	
</head>

<body>
<?php
  $id = (isset($_GET['id']) ? $_GET['id'] : "");

  if (!$id) {
     echo "<p> Indicate bug to delete .</p> </body> </html>";
     exit;
  }  
  
  require('mysqli_oop_connect.php');


  $q = "DELETE FROM reports WHERE id=$id LIMIT 1";
  
  $QueryResult = @$mysqli->query($q);

// Step 3
  if ($QueryResult) {
	mysqli_close($link);
	header("location: BugReport.php");
  } 
  else {
  	  echo "<p>Unable to execute the query. Error code " . $mysqli->errno . ": " . $mysqli->error. " </p> </body> </html>";
  }

  $mysqli->close();
?>  
</body>
</html>
