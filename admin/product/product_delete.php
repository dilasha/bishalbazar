<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "DELETE FROM product WHERE prodID = $id";
	$parse = oci_parse($connection, $query);
	if (oci_execute($parse)) {
		header("location:product_list.php");
	}
}
?>