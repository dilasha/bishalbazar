<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/t_head.php');

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "DELETE FROM message WHERE msgID = $id";
	$parse = oci_parse($connection, $query);
	if (oci_execute($parse)) {
		//echo "Data inserted Successfully<hr>";
		header("location:trader_notification.php");
	}
}
?>