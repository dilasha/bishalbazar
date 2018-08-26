<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
$entrymsg = "";
$query = "SELECT * FROM category";
$parse = oci_parse($connection, $query);
oci_execute($parse);
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
		include ($doc_root . '/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>Category List</h2>
			<div class="col-md-10">
				<div class="table-responsive">
					<table class="table table-condensed">
						<tr>
							<th>ID</th>
							<th>Category Name</th>
							<th>Category Description</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
						<?php
						$c = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$c++;
							echo "<tr>";
							echo "<td>" . $c . "</td>";
							echo "<td>" . $row['CATNAME'] . "</td>";
							echo "<td>" . $row['CATDESC'] . "</td>";
							echo "<td><a class='link' href='category_edit.php?id=" . $row['CATID'] . "'>Edit</a></td>";
							echo "<td><a class='link' onclick='return ConfirmDelete()' href='category_delete.php?id=" . $row['CATID'] . "'>Delete</a></td>";
							echo "</tr>";

						}
						?>
					</table>
				</div>
			</div>
		</div>

	</body>

</html>
