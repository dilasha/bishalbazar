<?php
session_start();
if (!isset($_SESSION['user'])) {
	$url = "http://quiet-ravine-14266.herokuapp.com/index.php";
	echo "<script>window.location'" . $url . "';</script>";
}
?>
