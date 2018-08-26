<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/Team6/includes/head.php');

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

if (isset($_SESSION['userid'])) {
	$customer = $_SESSION['userid'];
	$query_cart = "SELECT COUNT(orderID) as RCOUNT FROM c_order where prodID=$id and custID=$customer";
	$parse_cart = oci_parse($connection, $query_cart);
	oci_execute($parse_cart);
	oci_fetch($parse_cart);
	$total = oci_result($parse_cart, "RCOUNT");

	if ($total != 0) {
		$carted = "<span class='fa fa-check'></span>  Added To Cart";
		$disable = "disabled";
		$hide = "hidden";
	} else {
		$carted = "<span class='fa fa-plus'></span>  Add To Cart";
		$hide = "";
		$disable = "";
	}

	if (isset($_POST['btnAddToCart'])) {
		if (isset($_SESSION['userid'])) {
			$custID = $_SESSION['userid'];
			$prodID = $_POST['numProdID'];
			$shopID = $_POST['numShopID'];
			$quantity = $_POST['numQuantity'];
			$query_add = "INSERT INTO c_order VALUES (orderSeq.nextVal,$custID,$shopID,$prodID,$quantity)";
			$parse_add = oci_parse($connection, $query_add);
			if (oci_execute($parse_add)) {
				$carted = "<span class='fa fa-check'></span>  Added To Cart";
				$disable = "disabled";
				$hide = "hidden";
			}
		}
	}
} else {
	$disable = "disabled";
	$hide = "hidden";
	$carted = "Not Signed In";

}
?>
<!DOCTYPE html>
<html>
	<head>
	</head>

	<body>
		<?php
		include ($doc_root . '/Team6/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://localhost/Team6/index.php">Home</a>
				</li>
				<li>
					<a href="http://localhost/Team6/site/shop.php">Shop</a>
				</li>
				<li class="active">
					Product : <?php echo $prodName; ?>
				</li>
			</ul>
			<div class="content">
				<h3><?php echo $prodName; ?></h3>
				<div class="col-md-6">
					<table class="table prod-view table-bordered">
						<tr>
							<th>Seller:</th>
							<td><?php echo $sellerName; ?>
							</td>
						</tr>
						<tr>
							<th>Shop:</th>
							<td><?php echo $shopName; ?>
							</td>
						</tr>
						<tr>
							<th>Category:</th>
							<td><?php echo $prodCat; ?>
							</td>
						</tr>
						<tr>
							<th>Price:</th>
							<td>$<?php echo $prodRate; ?>
							</td>
						</tr>
					</table>

					<form action="" method="post">
						<div class="form-group row">
							<div class="col-md-3">
								<a href="http://localhost/Team6/site/shop.php" class="btn btn-cart"><span class="fa fa-reply"></span> Continue Shopping</a>
							</div>
							<div class="col-md-offset-1 col-md-5">
								<input type="number" placeholder="Enter Quantity" class="form-control" <?php echo $disable; ?> required name="numQuantity">
								<input type="number" value="<?php echo $id; ?>" hidden required name="numProdID">
								<input type="number" value="<?php echo $prodShop; ?>" hidden required name="numShopID">											
							</div>
							<div class="col-md-2 col-md-offset-1 pull-right"> 
								<button <?php echo $disable; ?> type="submit" name="btnAddToCart" class="btn btn-cart pull-right">
									<?php echo $carted; ?> 
								</button>
							</div>
					</div>
					</form>

				</div>
				<div class="col-md-4 col-md-offset-1">
					<img alt="" src="http://localhost/Team6/images/products/<?php echo $prodImg; ?>" class="img-responsive" />

				</div>

			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
