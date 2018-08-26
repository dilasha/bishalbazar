<?php
session_start();
include ($doc_root . '/connect.php');
if (!isset($_SESSION['user'])) {
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/admin/admin_login.php'</script>";
} else {
	if ($_SESSION['role'] != "Admin") {
		echo "<script>alert('You do not have permission to acces this page. You will be logged out')</script>";
		echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/logout.php'</script>";
	}
}
?>
<title>Admin-BishalBazaar Supermarket</title>
<link rel="shortcut icon" type="image/png" href="http://quiet-ravine-14266.herokuapp.com/images/favicon.png"/>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--css links-->
<link rel="stylesheet" href="http://quiet-ravine-14266.herokuapp.com/css/bootstrap.css" media="screen">
<link rel="stylesheet" href="http://quiet-ravine-14266.herokuapp.com/css/sweetalert.css" media="screen">
<!--for glyphicons-->
<link rel="stylesheet" href="http://quiet-ravine-14266.herokuapp.com/fonts/font-awesome-4.3.0/css/font-awesome.min.css">
<!--for navbar-->
<link rel="stylesheet" type="text/css" href="http://quiet-ravine-14266.herokuapp.com/css/reset.css">
<link rel="stylesheet" type="text/css" href="http://quiet-ravine-14266.herokuapp.com/css/main.css">
<!-- custom css-->
<link rel="stylesheet" href="http://quiet-ravine-14266.herokuapp.com/css/backend.css">

<!--javascript links-->
<script type="text/javascript" src="http://quiet-ravine-14266.herokuapp.com/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://quiet-ravine-14266.herokuapp.com/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://quiet-ravine-14266.herokuapp.com/js/sweetalert.min.js"></script>
<script type="text/javascript" src="http://localhost/Team6/slider/PgwSlider-master/pgwslider.min.js"></script>

<script type="text/javascript" src="http://quiet-ravine-14266.herokuapp.com/js/jquery.js"></script>
<script type="text/javascript" src="http://quiet-ravine-14266.herokuapp.com/js/main.js"></script>

<?php
include ($doc_root . '/includes/send_function.php');
?>