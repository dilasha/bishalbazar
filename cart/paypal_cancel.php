<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/includes/head.php');

if (!isset($_SESSION['user'])) {
	echo "<script>alert('You do not have permission to acces this page.')</script>";
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
}
?>
<!DOCTYPE html>
<html>
	<head></head>

	<body>
		<?php
		include ($doc_root . '/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
				</li>
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/cart/cart_list.php">Cart</a>
				</li>
				<li class="active">
					Payment Cancelled
				</li>
			</ul>
			<h3>Payment Cancelled</h3>
			<div class="content">
				<h4>Your payment has been cancelled. We left your cart items untouched.</h4>
				<h5>You may checkout at a later time.</h5>

			</div>
		</div>
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
