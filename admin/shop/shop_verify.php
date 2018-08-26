<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$entrymsg = "";
$uID = $_SESSION['userid'];
$query = "SELECT * FROM shop where shopStatus='Unverified'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
?>
<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
?>
<!DOCTYPE html>
<html>
	<head>
				
		<script language="javascript">
			function ConfirmDelete() {
				return confirm("Do you want to permanently delete this entry?");
			}
			//onclick='return ConfirmDelete()'
		</script>
	</head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2></h2>
			<div class="col-md-12">
				<h2>Shop List</h2>
				<div class="table-responsive">
					<table class="table">
						<tr>
							<th>ID</th>
							<th>Shop Name</th>
							<th>Shop Banner</th>
							<th>Floor Number</th>
							<th>Shop Status</th>
							<th>Verify Request</th>
							<th>Delete Request</th>
						</tr>
						<?php
						$c = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$c++;
							echo "<tr>";
							echo "<td>" . $c . "</td>";
							echo "<td>" . $row['SHOPNAME'] . "</td>";
							echo "<td><img class='responsive' style='max-height:100px;' src='http://quiet-ravine-14266.herokuapp.com/images/shops/" . $row['SHOPIMG'] . "'</td>";
							echo "<td>" . $row['FLOORNUM'] . "</td>";
							echo "<td>" . $row['SHOPSTATUS'] . "</td>";
							echo "<td><a class='btn btn-success' href='shop_confirm.php?id=" . $row['SHOPID'] . "&owner=".$row['USERID']."'>Verify  <span class='fa fa-check-square'></span></a></td>";
							echo "<td><a onclick='return ConfirmDelete()' class='btn btn-danger' href='shop_delete.php?id=" . $row['SHOPID'] . "&owner=".$row['USERID']."'>Delete <span class='fa fa-minus-square'></span> </a></td>";
							echo "</tr>";

						}
						?>
					</table>
				</div>
			</div>

	</body>

</html>
