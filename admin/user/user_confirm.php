<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
$userID = $_REQUEST['id'];
$query_upd = "UPDATE user_account SET userStatus='Verified' where userID='$userID'";
$parse_upd = oci_parse($connection, $query_upd);
if (oci_execute($parse_upd)) {
	echo "<script>window.location='user_verify.php'</script>";
}
?>