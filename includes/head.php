<?php
session_start();
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
if (isset($_SESSION['user'])) {
	if ($_SESSION['role'] != "Customer") {
		echo "<script>alert('You do not have permission to acces this page. You will be logged out')</script>";
		echo "<script>window.location='http://localhost/Team6/logout.php'</script>";
	}
}
?>
<title>BishalBazaar Supermarket</title>
<link rel="shortcut icon" type="image/png" href="http://localhost/Team6/images/favicon.png"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--css links-->
<link rel="stylesheet" href="http://localhost/Team6/css/bootstrap.css" media="screen">
<link rel="stylesheet" href="http://localhost/Team6/css/sweetalert.css" media="screen">
<link rel="stylesheet" href="http://localhost/Team6/fonts/font-awesome-4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="http://localhost/Team6/slider/PgwSlider-master/pgwslider.min.css">
<link rel="stylesheet" href="http://localhost/Team6/css/frontend.css">

<!--javascript links-->
<script type="text/javascript" src="http://localhost/Team6/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://localhost/Team6/js/sweetalert.min.js"></script>
<script type="text/javascript" src="http://localhost/Team6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://localhost/Team6/slider/PgwSlider-master/pgwslider.min.js"></script>

<script type="text/javascript" src="http://localhost/Team6/js/google_map.js"></script>

<?php
include ($doc_root . '/Team6/includes/send_function.php');
?>