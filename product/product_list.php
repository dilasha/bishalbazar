<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/t_head.php');
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
		include ($doc_root . '/Team6/includes/t_navigation.php');
		?>
		<div class="content row">
			<h2>Product List</h2>
			<div class="col-md-11">
				<div class="table-responsive">
					<table class="table table-condensed">
						<thead>
							<th>S.N</th>
							<th>Shop</th>
							<th>Category</th>
							<th>Name</th>
							<th>Photo</th>
							<th>Price</th>
							<th>Featured</th>
							<th>Edit</th>
							<th>Delete</th>
						</thead>
						<?php
						$uID=$_SESSION['userid'];
						$query = "select * from product p, shop s, user_account u where u.userID=s.userID and p.shopID=s.shopID and u.userID=$uID";
						$parse = oci_parse($connection, $query);
						oci_execute($parse);
						$c = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$c++;
							echo "<tr>";
							echo "<td>" . $c . "</td>";
							$queryShop_id = $row['SHOPID'];
							$queryShop = "SELECT shopName FROM shop WHERE shopID=$queryShop_id";
							$parseShop = oci_parse($connection, $queryShop);
							oci_execute($parseShop);
							while ($rowShop = oci_fetch_assoc($parseShop)) {
								echo "<td>" . $rowShop['SHOPNAME'] . "</td>";
							}

							$queryCatID = $row['PRODCATEGORY'];
							$queryCat = "SELECT * FROM category WHERE catID=$queryCatID";
							$parseCat = oci_parse($connection, $queryCat);
							oci_execute($parseCat);
							while ($rowCat = oci_fetch_assoc($parseCat)) {
								echo "<td>" . $rowCat['CATNAME'] . "</td>";
							}
							echo "<td>" . $row['PRODNAME'] . "</td>";
							echo "<td><img height='150' src='http://localhost/Team6/images/products/" . $row['PRODIMG'] . "' /></td>";
							echo "<td> $" . $row['PRODRATE'] . "</td>";
							echo "<td>" . $row['PRODFEAT'] . "</td>";
							echo "<td><a class='link' href='product_edit.php?id=" . $row['PRODID'] . "'>Edit</a></td>";
							echo "<td><a onclick='return ConfirmDelete()' class='link' href='product_delete.php?id=" . $row['PRODID'] . "'>Delete</a></td>";
							echo "</tr>";
						}
						?>
					</table>

				</div>
			</div>

	</body>

</html>
