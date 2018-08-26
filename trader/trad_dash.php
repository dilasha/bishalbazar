<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/t_head.php');
?>
<!DOCTYPE html>
<html>
	<head></head>

	<body>

		<?php
		include ($doc_root . '/Team6/includes/t_navigation.php');
		?>
		<div class="content">
			<table class="table table-condensed">
				<thead>
					<th>Shop</th>
					<th>Item</th>
					<th>Amount</th>
				</thead>
				<?php
				$query = "SELECT * FROM traderSales where sellerID=".$_SESSION['userid']."";
				$parse = oci_parse($connection, $query);
				oci_execute($parse);
				while ($row = oci_fetch_assoc($parse)) {
					echo "<tr>";
					echo "<td>" . $row['SHOPNAME'] . "</td>";
					echo "<td>" . $row['PRODNAME'] . "</td>";
					echo "<td>" . $row['AMOUNT'] . "</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>

	</body>

</html>
