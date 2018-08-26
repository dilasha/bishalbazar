<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/includes/head.php');

if (!isset($_SESSION['user'])) {
	echo "<script>alert('You do not have permission to acces this page.')</script>";
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
}
$uID = $_SESSION['userid'];
$id = $_REQUEST['id'];
$query = "select * from payment p, slot s where p.slotID=s.slotID and p.transactionID='$id'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
while ($row = oci_fetch_assoc($parse)) {
	$start = $row['TIMESTART'];
	$end = $row['TIMEFINISH'];
	$slotDate = $row['COLLECTDATE'];
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
					Payment Success
				</li>
			</ul>
			<h3>Success!</h3>
			<div class="content">
				<h4>We have recieved your payment! Thank you for shopping with us.</h4>
				<h5>You may come to collect your items at any time between <?php echo $start . " to " . $end . " on " . $slotDate; ?></h5>
				A notification has been sent to you so you may look at the time slot anytime you wish.
					To make a change in your time slot, please contact us via email, message or phone.
			</div>
		</div>
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
