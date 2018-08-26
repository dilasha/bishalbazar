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
		}

		$id = $_REQUEST['id'];
		$query = "SELECT * FROM user_account u, category c, shop s, product p where p.prodID=$id and p.prodCategory=c.catID and s.shopID=p.shopID and s.userID=u.userID";
		$parse = oci_parse($connection, $query);
		oci_execute($parse);
		while ($row = oci_fetch_assoc($parse)) {
			$prodName = $row['PRODNAME'];
			$prodRate = $row['PRODRATE'];
			$prodImg = $row['PRODIMG'];
			$prodCat = $row['CATNAME'];
			$prodShop = $row['SHOPID'];
			$shopName = $row['SHOPNAME'];
			$sellerName = $row['USERNAME'];
		}
		if (isset($_POST['btnEditCart'])) {
			$eQuanity = $_POST['numQuantity'];
			$query = "UPDATE c_order SET quantity=:eQuanity where prodID=$id";
			$parse = oci_parse($connection, $query);

			oci_bind_by_name($parse, ":eQuanity", $eQuanity);
			if (oci_execute($parse)) {
				echo "<script>window.location='cart_list.php'</script>";
			}
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
					Profile
				</li>
			</ul>
			<h3>Profile</h3>
			<div class="content row">
				<div class="col-md-6">
					<table class="table prod-view table-bordered">
						<tr>
							<th>Seller:</th>
							<td><?php echo $sellerName; ?></td>
						</tr>
						<tr>
							<th>Shop:</th>
							<td><?php echo $shopName; ?></td>
						</tr>
						<tr>
							<th>Category:</th>
							<td><?php echo $prodCat; ?></td>
						</tr>
						<tr>
							<th>Price:</th>
							<td>Rs. <?php echo $prodRate; ?></td>
						</tr>
					</table>

					<form action="" method="post">
						<div class="form-group row">
							<div class="col-md-3">
								<a href="http://quiet-ravine-14266.herokuapp.com/site/shop.php" class="btn btn-cart"><span class="fa fa-reply"></span> Continue Shopping</a>
							</div>
							<div class="col-md-offset-1 col-md-5">
							<?php
							$queryQ = "SELECT * FROM c_order where prodID=$id";
							$parseQ = oci_parse($connection, $queryQ);
							oci_execute($parseQ);
							while ($rowQ = oci_fetch_assoc($parseQ)) {
								$quan = $rowQ['QUANTITY'];
							}
							?>
							
								<input type="number" placeholder="Enter Quantity" value="<?php echo $quan; ?>" class="form-control"  required name="numQuantity">
							</div>
							<div class="col-md-2 col-md-offset-1 pull-right">
								<button type="submit" name="btnEditCart" class="btn btn-cart pull-right">
									Edit Quantity
								</button>
							</div>
						</div>
					</form>

				</div>
				<div class="col-md-4 col-md-offset-1">
					<img alt="" src="http://quiet-ravine-14266.herokuapp.com/images/products/<?php echo $prodImg; ?>" class="
					img-responsive" />

				</div>

			</div>
		</div>
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
