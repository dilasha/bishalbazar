<?php
session_start();
if (!isset($_SESSION['user'])) {
	$url = "http://localhost/Team6/index.php";
	echo "<script>window.location'" . $url . "';</script>";
}
?>
