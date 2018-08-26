<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/head.php');
$errormsg = "";
if (isset($_POST['btnAdminLog'])) {
	$adminEmail = $_POST['adminEmail'];
	$adminPass = $_POST['adminPass'];
	$adminPass = sha1($adminPass);
	$uID = "";
	$uStatus = "";
	$query_login = "SELECT * FROM user_account where userRole='Admin' and userEmail='$adminEmail' and userPassword='$adminPass'";
	$parse_login = oci_parse($connection, $query_login);
	oci_execute($parse_login);
	while ($row_logged = oci_fetch_assoc($parse_login)) {
		$uID = $row_logged['USERID'];
		$uName = $row_logged['USERNAME'];
		$uStatus = $row_logged['USERSTATUS'];
	}

	if ($uID != null && $uID != 0) {
		if ($uStatus == "Verified") {
			$_SESSION['user'] = $uName;
			$_SESSION['role'] = "Admin";
			$_SESSION['userid'] = $uID;
			$url = "http://quiet-ravine-14266.herokuapp.com/admin/admin_dash.php";
			echo "<script>window.location='" . $url . "';</script>";
		} else {
			$errormsg = "<div class='form-group'><div class='err-admin'><span class='fa fa-exclamation'></span> Your account is awaiting verification/reactivation.</div></div>";
		}

	} else {
		$errormsg = "<div class='form-group'><div class='err-admin'><span class='fa fa-exclamation'></span> Your email or password was incorrect. Please try again. </div></div>";
	}

}
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body class="admin-log-page row">
		<div class="content col-md-3 admin-form">
			<a href="http://quiet-ravine-14266.herokuapp.com/"><img class="img-responsive" src="http://quiet-ravine-14266.herokuapp.com/images/logo-w.png"></a>
			<div class="row admin-form-title">
				Administrator Login
			</div>
			<form class="form-horizontal" method="post" action="">

				<div class="form-group">

					<input required name="adminEmail" type="email" class="form-control input-sm" placeholder="Email">

				</div>
				<div class="form-group">
					<input required name="adminPass" type="password" class="form-control input-sm" placeholder="Password">

				</div>
				<div class="form-group">
					<button name="btnAdminLog" type="submit" class="btn btn-default btn-sm pull-right btn-black">
						Login
					</button>

				</div>
			</form>

		</div>
		<?php echo $errormsg; ?>
	</body>

</html>
