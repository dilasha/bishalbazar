<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/Team6/includes/head.php');
$errormsg = "";
$regmsg = "";

if (isset($_POST['btnLog'])) {
	$logEmail = $_POST['logEmail'];
	$logPass = $_POST['logPass'];
	$logPass = sha1($logPass);
	$rdoLogRole = $_POST['rdoLogRole'];
	$uID = "";
	$query_login = "SELECT * FROM user_account where userRole=:rdoLogRole and userEmail=:logEmail and userPassword=:logPass";

	$parse_login = oci_parse($connection, $query_login);

	oci_bind_by_name($parse_login, ":rdoLogRole", $rdoLogRole);
	oci_bind_by_name($parse_login, ":logEmail", $logEmail);
	oci_bind_by_name($parse_login, ":logPass", $logPass);

	oci_execute($parse_login);
	while ($row_logged = oci_fetch_assoc($parse_login)) {
		$uID = $row_logged['USERID'];
		$uStatus = $row_logged['USERSTATUS'];
		$uName = $row_logged['USERNAME'];
	}
	if ($uID != null && $uID != 0) {
		if ($uStatus == "Verified") {
			$_SESSION['user'] = $uName;
			$_SESSION['role'] = $rdoLogRole;
			$_SESSION['userid'] = $uID;
			$url = "http://quiet-ravine-14266.herokuapp.com/index.php";
			if ($rdoLogRole == "Customer") {
				$url = "http://quiet-ravine-14266.herokuapp.com/index.php";
			} else if ($rdoLogRole == "Trader") {
				$url = "http://quiet-ravine-14266.herokuapp.com/trader/trad_dash.php";
			}
			echo "<script>window.location='" . $url . "';</script>";
		} else {
			$errormsg = "<div class='alert alert-info'><span class='fa fa-exclamation'></span> Your account is awaiting verification/reactivation. Please try later.</div>";
		}
	} else {
		$errormsg = "<div class='alert alert-danger'><span class='fa fa-exclamation'></span> Your email or password was incorrect. Please try again.</div>";
	}

}
if (isset($_POST['btnReg'])) {
	function getImage() {
		$regPic = "";
		$regPic_name = $_FILES['imgProPic']['name'];
		$regPic_type = $_FILES['imgProPic']['type'];
		$regPic_size = $_FILES['imgProPic']['size'];
		$regPic_tmp_name = $_FILES['imgProPic']['tmp_name'];

		if ($regPic_name == "") {
			$regPic = "userPic.jpg";
		} else {
			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$dir = $doc_root . "Team6/images/users/" . $regPic_name;
			move_uploaded_file($regPic_tmp_name, $dir);
			$regPic = $regPic_name;
		}
		return $regPic;
	}

	//extract data from registration form
	$regName = $_POST['regName'];
	$regEmail = $_POST['regEmail'];
	$regPass = $_POST['regPass'];
	$regConfPass = $_POST['regConfPass'];

	$regPic = getImage();
	$regRole = $_POST['rdoRegRole'];
	$regStatus = "";
	if ($regRole == "Admin" || $regRole == "Trader") {
		$regStatus = "Unverified";
	} else {
		$regStatus = "Verified";
	}

	$available = 1;
	$query_available = "SELECT * FROM user_account";
	$parse_available = oci_parse($connection, $query_available);
	oci_execute($parse_available);
	while ($row_available = oci_fetch_assoc($parse_available)) {
		$userEmail = $row_available['USEREMAIL'];
		if ($regEmail == $userEmail) {
			$available = 0;
		}
	}
	if ($available != 1) {
		$regmsg = "<div class='alert alert-danger'><span class='fa fa-exclamation'></span> This email is already registered. Please enter another.</div>";
	} else {

		if ($regPass != $regConfPass) {
			$validity = 0;
		} else {
			$validity = 1;
		}
		if ($validity != 1) {
			$regmsg = "<div class='alert alert-danger'><span class='fa fa-exclamation'></span> You password and confirmation passwords do not match. Please try again.</div>";
		} else {

			$regPass = sha1($regPass);

			$query_user = "INSERT INTO user_account VALUES(userSeq.nextval,:regName,:regEmail,:regPass,:regRole,:regStatus,:regPic)";
			$parse_user = oci_parse($connection, $query_user);

			oci_bind_by_name($parse_user, ":regName", $regName);
			oci_bind_by_name($parse_user, ":regEmail", $regEmail);
			oci_bind_by_name($parse_user, ":regPass", $regPass);
			oci_bind_by_name($parse_user, ":regRole", $regRole);
			oci_bind_by_name($parse_user, ":regStatus", $regStatus);
			oci_bind_by_name($parse_user, ":regPic", $regPic);

			if (oci_execute($parse_user)) {
				$regmsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Your account has been created.</div>";
			} else {
				$regmsg = "<div class='alert alert-danger'><span class='fa fa-exclamation'></span> Something went wrong. Please try again.</div>";
			}
		}
	}

}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php ?>
	</head>

	<body>
		<?php
		include ($doc_root . '/Team6/includes/navigation.php');
		?>
		<div class="container">

			<div class="content">
				<ul class="breadcrumb">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
					</li>
					<li class="active">
						Sign in | Register
					</li>
				</ul>
				<div class="row">
					<div class="col-md-5">
						<h3>SIGN IN</h3>
						<?php echo $errormsg; ?>
						<form class="form-horizontal" method="post" action="">

							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input required name="logEmail" type="email" class="form-control input-sm" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input required name="logPass" type="password" class="form-control input-sm" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Role</label>
								<div class="col-lg-10">
									<div class="radio">
										<label>
											<input type="radio" name="rdoLogRole" value="Customer" checked>
											Customer </label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="rdoLogRole" value="Trader">
											Trader </label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button name="btnLog" type="submit" class="btn btn-default btn-sm btn-black">
										Sign in
									</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-5 col-md-offset-1">
						<h3>REGISTER</h3>
						<?php echo $regmsg; ?>
						<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-sm-2 control-label">Fullname</label>
								<div class="col-sm-10">
									<input type="text" required name="regName" class="form-control input-sm" placeholder="Full Name">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<input type="email" required name="regEmail" class="form-control input-sm" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10">
									<input type="password" required name="regPass" class="form-control input-sm" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="password" required name="regConfPass" class="form-control input-sm" placeholder="Password">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Account Photo</label>
								<div class="col-sm-10">
									<input type="file" name="imgProPic" class="input-sm">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label">Role</label>
								<div class="col-lg-10">
									<div class="radio">
										<label>
											<input type="radio" name="rdoRegRole" value="Customer" checked>
											Customer </label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="rdoRegRole" value="Trader">
											Trader </label>
									</div>
									<div class="radio">
										<label>
											<input type="radio" name="rdoRegRole" value="Admin">
											Admin </label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<div class="checkbox">
										<label>
											<input required name="chkTerms" type="checkbox">
											I agree to the terms and conditions. </label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button name="btnReg" type="submit" class="btn btn-sm btn-black">
										Sign up
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
