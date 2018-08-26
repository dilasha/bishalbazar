<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>Sales</h2>
			<div class="table-responsive">
				<table class="table table-condensed table-bordered table-hover">
					<thead>
						<th>S.N</th>
						<th>Seller</th>
						<th>Shop</th>
						<th>Item</th>
						<th>Rate</th>
						<th>Quantity</th>
						<th>Amount</th>
						<th>Purchase Date</th>
					</thead>
					<?php
					$query = "select * from purchaseHistory order by paymentDate DESC";
					$parse = oci_parse($connection, $query);
					oci_execute($parse);
					$c = 0;
					while ($row = oci_fetch_assoc($parse)) {
						echo "<tr>";
						$c++;
						echo "<td>$c</td>";
						echo "<td>" . $row['SELLERNAME'] . "</td>";
						echo "<td>" . $row['SHOPNAME'] . "</td>";
						echo "<td>" . $row['PRODNAME'] . "</td>";
						echo "<td>$" . $row['PRODRATE'] . "</td>";
						echo "<td>" . $row['QUANTITY'] . "</td>";
						echo "<td>$" . $row['PRODAMT'] . "</td>";
						echo "<td>" . $row['PAYMENTDATE'] . "</td>";
						echo "<tr>";
					}
					?>
				</table>
			</div>

		</div>
		</div>

	</body>

</html>
