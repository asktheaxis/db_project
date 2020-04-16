<?php

session_start();

if (!isset($_SESSION['dealer_id'])) {
   require('../includes/login_functions.inc.php');
   redirect_sales_report();
}

$page_title = 'Bug Reports';
include('../includes/header.html');
echo '<h1>Sales Database</h1>';

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

  
$q = "select COUNT(*) from sells";
if ($r = $conn->query($q)){

  if ($r->fetchColumn() > 0) {

    $q = "SELECT * from sells";

    echo "<h1>Sales Database</h1>";
    
    echo "<table>\n";
    echo "<tr> <th>VIN</th> <th>DEALER ID</th> <th>CUSTOMER ID</th> <th>SALE PRICE</th> <th>SALE DATE</th> </tr>\n";
    
    foreach ($conn->query($sql) as $row) {  ?>  
      <tr>
        <td><?php echo htmlspecialchars($row['s_vin']); ?></td>
        <td><?php echo htmlspecialchars($row['s_dealer_id']); ?></td>
        <td><?php echo htmlspecialchars($row['s_customer_id']); ?></td>
        <td><?php echo htmlspecialchars($row['sale_price']); ?></td>
        <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
      </tr>
      <?php
    }
    echo "</table>\n";
  }
}

$conn = NULL;
?>

<p><a href="NewSale.html">Create New Sales Report</a></p>

</body>
</html>
