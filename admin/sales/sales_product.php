<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$entrymsg = "";
?>

<!DOCTYPE html>
<html>
	<head>

	</head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>Sales by Product</h2>
			<div class="col-md-6">
				<div class="table-responsive">
					<table class="table table-condensed">
						<thead>
							<th>Product Name</th>
							<th>Number of sales</th>
						</thead>

						<?php
						$query = "SELECT * FROM productSales";
						$parse = oci_parse($connection, $query);
						oci_execute($parse);
						while ($row = oci_fetch_assoc($parse)) {
							echo "<tr>";
							echo "<td>" . $row['PRODNAME'] . "</td>";
							echo "<td>" . $row['NUMSALES'] . "</td>";
							echo "</tr>";
						}
						?>
					</table>
				</div>
			</div>
			<div class="col-md-6">

			</div>
		</div>

	</body>

</html>
