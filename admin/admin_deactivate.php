<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/head.php');
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "UPDATE user_account SET userStatus='Deactivated' where userID=$id";
	$parse = oci_parse($connection, $query);
	if (oci_execute($parse)) {
		echo "<script>alert('Your account has been deactivated. You will be now logged out.')</script>";
		echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/logout.php'</script>";
	}
}
?>