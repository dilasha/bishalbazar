<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/includes/head.php');

if (!isset($_SESSION['user'])) {
	echo "<script>alert('You do not have permission to acces this page.')</script>";
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
}

$uID = $_SESSION['userid'];
$query = "select p.prodID, c.custID, u.userName, s.userID, s.shopName, p.prodName, p.prodRate, p.prodImg, c.quantity from c_order c, user_account u, product p, shop s
where c.prodID=p.prodID and s.shopID=p.shopID and c.shopID=s.shopID and u.userID=s.userID and c.custID=$uID";
$parse = oci_parse($connection, $query);
oci_execute($parse);
$c = 0;
?>
<!DOCTYPE html>
<html>
	<head>
		
		<script language="javascript">
			function ConfirmDelete() {
				return confirm("Do you want to permanently delete this entry?");
			}

			function ConfirmReset() {
				return confirm("Do you want to permanently reset your cart?");
			}

			//onclick='return ConfirmDelete()'
		</script>
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
					Cart
				</li>
			</ul>
			<h3>Cart</h3>
			<div class="content">
				<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Seller</th>
						<th>Shop</th>
						<th>Product Name</th>
						<th>Photo</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Amount</th>
						<th>Edit</th>
						<th>Delete</th>
					</thead>
					<?php
					$total = 0;
					while ($row = oci_fetch_assoc($parse)) {
						$c++;
						echo "<tr>";
						echo "<td>" . $row['USERNAME'] . "</td>";
						echo "<td>" . $row['SHOPNAME'] . "</td>";
						echo "<td>" . $row['PRODNAME'] . "</td>";
						echo "<td><img height='120' src='http://quiet-ravine-14266.herokuapp.com/images/products/" . $row['PRODIMG'] . "' /></td>";
						echo "<td>$" . $row['PRODRATE'] . "</td>";
						echo "<td>" . $row['QUANTITY'] . "</td>";
						$amount = $row['PRODRATE'] * $row['QUANTITY'];
						echo "<td>Rs. " . $amount . "</td>";
						echo "<td><a href='http://quiet-ravine-14266.herokuapp.com/cart/cart_edit.php?id=" . $row['PRODID'] . "'>Edit</a></td>";
						echo "<td><a onclick='return ConfirmDelete()' href='http://quiet-ravine-14266.herokuapp.com/cart/cart_delete.php?id=" . $row['PRODID'] . "'>Delete</a></td>";
						echo "</tr>";
						$total += $amount;
					}
					?>
				<tfoot>
					<td colspan=5></td>
					<th>Total</th>
					<td colspan="3"><?php echo "Rs. " . $total; ?></td>
					
				</tfoot>
				</table>
				</div>
				<div class="pull-right">
					<a href="http://quiet-ravine-14266.herokuapp.com/site/shop.php" class="btn btn-cart"><span class="fa fa-reply"></span>  Back to Shopping</a>
					<?php
					if ($total != 0) {
						echo "<a onclick='return ConfirmReset()' href='cart_reset.php?id=$uID' class='btn btn-cart'><span class='fa fa-refresh'></span>  Reset Cart</a>";
						echo "<a href='checkout_confirm.php' class='btn btn-cart'><span class='fa fa-shopping-cart'></span>   Checkout</a>";
					}
					?>
				</div>
			</div>
		</div>
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
