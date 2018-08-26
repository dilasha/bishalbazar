<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/t_head.php');
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "DELETE FROM c_order WHERE prodID = $id and custID=".$_SESSION['userid']."";
	$parse = oci_parse($connection, $query);
	if (oci_execute($parse)) {
		header("location:cart_list.php");
	}
}
?>