<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/t_head.php');
$entrymsg = "";
$uID = $_SESSION['userid'];
$query = "SELECT * FROM shop where shopStatus='Verified' and userID=$uID";
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
		include ($doc_root . '/includes/t_navigation.php');
		?>
		<div class="content row">
			<h2>Shop List</h2>
			<div class="col-md-11">
				<div class="table-responsive">
					<table class="table table-condensed">
						<tr>
							<th>ID</th>
							<th>Shop Name</th>
							<th>Shop Banner</th>
							<th>Floor Number</th>
							<th>Shop Status</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
						<?php

						$c = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$c++;
							echo "<tr>";
							echo "<td>" . $c . "</td>";
							echo "<td>" . $row['SHOPNAME'] . "</td>";
							echo "<td><img height='150' src='http://quiet-ravine-14266.herokuapp.com/images/shops/" . $row['SHOPIMG'] . "'</td>";
							echo "<td>" . $row['FLOORNUM'] . "</td>";
							echo "<td>" . $row['SHOPSTATUS'] . "</td>";
							echo "<td><a class='link' href='shop_edit.php?id=" . $row['SHOPID'] . "'>Edit</a></td>";
							echo "<td><a onclick='return ConfirmDelete()' class='link' href='shop_delete.php?id=" . $row['SHOPID'] . "'>Delete</a></td>";
							echo "</tr>";

						}
						?>
					</table>
				</div>
			</div>

	</body>

</html>
