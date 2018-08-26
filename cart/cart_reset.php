<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/Team6/includes/head.php');
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "DELETE FROM c_order WHERE custID=$id";
	$parse = oci_parse($connection, $query);
	oci_execute($parse);
	echo "<script>window.location='http://localhost/Team6/cart/cart_list.php'</script>";
}
?>