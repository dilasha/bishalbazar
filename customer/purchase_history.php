<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		include ($doc_root . '/includes/head.php');
		if (!isset($_SESSION['user'])) {
			echo "<script>alert('You do not have permission to acces this page.')</script>";
			echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
		} else {
			$id = $_SESSION['userid'];
			$query = "select * from purchaseHistory where custID=$id order by paymentDate DESC";
			$parse = oci_parse($connection, $query);
			oci_execute($parse);
		}
		?>
	</head>

	<body>
		<?php
		include ($doc_root . '/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
				</li>
				<li class="active">
					Purchase History
				</li>
			</ul>
			<h3>Purchase History</h3>
			<div class="content row">
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
						$c=0;
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
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
