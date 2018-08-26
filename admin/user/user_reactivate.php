<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "UPDATE user_account SET userStatus='Verified' where userID=$id";
	$parse = oci_parse($connection, $query);
	if (oci_execute($parse)) {

		header("location:user_list.php");

	}
}
?>