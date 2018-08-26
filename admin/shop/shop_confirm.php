<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
$shopID = $_REQUEST['id'];
$query_upd = "UPDATE shop SET shopStatus='Verified' where shopID='$shopID'";
$parse_upd = oci_parse($connection, $query_upd);
if (oci_execute($parse_upd)) {
	$reciever = $_REQUEST['owner'];
	$sender = $_SESSION['userid'];
	$text = "Your shop has been verified!";
	sendmessage($connection, $sender, $reciever, $text, "Notification");
	echo "<script>window.location='shop_verify.php'</script>";
}
?>