<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/includes/head.php');

if (!isset($_SESSION['user'])) {
	echo "<script>alert('You do not have permission to acces this page.')</script>";
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
}
//user id
if ($_GET['cm'])
	$user = $_GET['cm'];
//transaction id
if ($_GET['tx'])
	$tx = $_GET['tx'];
//status
if ($_GET['st'])
	$st = $_GET['st'];
//total amout paid
if ($_GET['amt'])
	$amt = $_GET['amt'];
//saving information to the database
if ($st == "Completed") {
	$query_slotD = "select sysdate+1 AS nextDay, sysdate AS payDate, TO_CHAR(SYSDATE,'SSSSS') AS payTime from dual";
	$parse_slotD = oci_parse($connection, $query_slotD);
	if (oci_execute($parse_slotD)) {
		while ($row_slotD = oci_fetch_assoc($parse_slotD)) {
			$payDate = $row_slotD['PAYDATE'];
			$payTime = $row_slotD['PAYTIME'];
			$nextDay = $row_slotD['NEXTDAY'];
		}
		if ($payTime >= 36000 && ($payTime + 1800) < 64800) {
			$slotStart = $payTime + 1800;
			$slotEnd = $payTime + 1800 + 7200;
			$slotDate = $payDate;
		} elseif ($payTime < 36000) {
			$slotStart = 36000 + 1800;
			$slotEnd = 36000 + 1800 + 7200;
			$slotDate = $payDate;
		} elseif (($payTime + 1800) >= 64800) {
			$slotStart = 36000 + 1800;
			$slotEnd = 36000 + 1800 + 7200;
			$slotDate = $nextDay;
		}
		$query_slot = "INSERT INTO slot VALUES(slotSeq.nextVal, to_char(to_date(" . $slotStart . ",'sssss'),'hh24:mi AM'), to_char(to_date(" . $slotEnd . ",'sssss'),'hh24:mi AM'),'$slotDate',to_char(to_date(" . $payTime . ",'sssss'),'hh24:mi'),'$payDate')";
		$parse_slot = oci_parse($connection, $query_slot);
		if (oci_execute($parse_slot)) {

			$query_bill = "INSERT INTO bill VALUES (billSeq.nextVal,'$user','$amt')";
			$parse_bill = oci_parse($connection, $query_bill);
			if (oci_execute($parse_bill)) {
				$query_pay = "INSERT INTO payment VALUES (paymentSeq.nextVal, billSeq.currVal, '$user', slotSeq.currVal, '$tx')";
				$parse_pay = oci_parse($connection, $query_pay);
				if (oci_execute($parse_pay)) {
					$query_order = "select c.orderID, p.prodID, s.userID, s.shopID, c.custID, c.quantity from c_order c, user_account u, shop s, product p where p.prodID=c.prodID and s.shopID=c.shopID and s.userID=u.userID and c.custID=$user";
					$parse_order = oci_parse($connection, $query_order);
					if (oci_execute($parse_order)) {
						while ($row = oci_fetch_assoc($parse_order)) {
							$orderID = $row['ORDERID'];
							$prodID = $row['PRODID'];
							$sellerID = $row['USERID'];
							$shopID = $row['SHOPID'];
							$custID = $row['CUSTID'];
							$quantity = $row['QUANTITY'];

							$query_sales = "INSERT INTO sales VALUES(salesSeq.nextVal,'$prodID','$sellerID','$shopID','$custID','$quantity',paymentSeq.currVal)";
							$parse_sales = oci_parse($connection, $query_sales);
							if (oci_execute($parse_sales)) {

							}
						}
						$query_del = "DELETE FROM c_order where custID=$custID";
						$parse_del = oci_parse($connection, $query_del);
						if (oci_execute($parse_del)) {

						}
						$query = "select * from payment p, slot s where p.slotID=s.slotID and p.transactionID='$tx'";
						$parse = oci_parse($connection, $query);
						oci_execute($parse);
						while ($row = oci_fetch_assoc($parse)) {
							$start = $row['TIMESTART'];
							$end = $row['TIMEFINISH'];
							$slotDate = $row['COLLECTDATE'];
							$sender = 'Admin';
							$reciever = $user;
							$text = "The timeslot duration for your latest transaction is $start to $end . Please collect your 
							purchase from the Goods Counter located in the ground floor of BishalBazar Complex. <br/> <strong>Thank you for shopping with us.</strong> ";
							$type = "Notification";
							sendmessage($connection, $sender, $reciever, $text, $type);
						}
						echo "<script>window.location='payment_success.php?id=" . $tx . "'</script>";
					}
				}
			}
		}
	}
}
?>

