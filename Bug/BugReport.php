<?php

session_start();

if (!isset($_SESSION['user_id'])) {
   require('../includes/login_functions.inc.php');
   redirect_user_bug();
}

$page_title = 'Bug Reports';
include('../includes/header.html');
echo '<h1>Bug Database</h1>';

require('mysqli_oop_connect.php');

  
$q = "SELECT * FROM Reports";
$r = $mysqli->query($q);

$num = $r->num_rows;
  
		
if ($num > 0) {

  echo "<h1>Bug Database</h1>";
  
  echo "<table>\n";
  echo "<tr> <th>ID</th> <th>&nbsp;</th> <th>Product</th> <th>Version</th> <th>OS</th> <th>Type</th> <th>Summary</th> <th>Status</th> <th>Reported by</th> <th>Report date</th> </tr>\n";
  
   for ($i=0; $i <$num; $i++) {
     $row = $r->fetch_object();     echo "<tr>";
	 echo "<td>" . $row->id . "</td>";
	 echo "<td width = '25'>" . "<a href='DeleteBug.php?id=" . $row->id . "'><img src='Delete-48x48.png' width='17' height='17' alt='' /></a></td>";
	 echo "<td>" . htmlspecialchars(stripslashes($row->product)) . "</td>";

	 echo "<td align='left'>" . $row->version . "</td><td align='left'>" . $row->os . "</td><td align='left'>" . $row->btype . "</td><td align='left'>" . $row->summary . "</td><td align='left'>" 
              . $row->status . "</td><td align='left'>" . $row->reported . "</td><td align='left'>" . $row->entered . "</td>";



	echo "</tr>\n";
  }
  echo "</table>\n";
}

$mysqli->close();
unset($mysqli);



?>

<p><a href="NewBug.html">Create New Bug Report</a></p>

</body>
</html>
