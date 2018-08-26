<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/t_head.php');

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "DELETE FROM shop WHERE shopID = $id";
	$parse = oci_parse($connection, $query);
	if (oci_execute($parse)) {
		//echo "Data inserted Successfully<hr>";
		header("location:shop_list.php");
	}
}
?>