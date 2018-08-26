<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$regmsg = "";

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
	$regStatus = "Verified";

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
				$regmsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Your account has been created. Please login.</div>";
			} else {
				$regmsg = "<div class='alert alert-danger'><span class='fa fa-exclamation'></span> Something went wrong. Please try again.</div>";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>User Add</h2>
			<div class="col-md-10">
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
							<button name="btnReg" type="submit" class="btn btn-default btn-sm btn-black">
								Sign up
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>
