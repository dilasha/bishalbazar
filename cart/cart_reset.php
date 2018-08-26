<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/includes/head.php');
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "DELETE FROM c_order WHERE custID=$id";
	$parse = oci_parse($connection, $query);
	oci_execute($parse);
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/cart/cart_list.php'</script>";
}
?>