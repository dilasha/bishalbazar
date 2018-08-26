<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	$query = "SELECT * FROM user_account WHERE userID=$id";
	$parse = oci_parse($connection, $query);
	oci_execute($parse);
	while ($row = oci_fetch_assoc($parse)) {
		$name = $row['USERNAME'];
		$photo = $row['USERPIC'];
		$email = $row['USEREMAIL'];
		$pwd = $row['USERPASSWORD'];
		$role = $row['USERROLE'];
	}
	if (isset($_POST['btnEditProfile'])) {
		$e_name = $_POST['txtName'];
		$e_email = $_POST['txtEmail'];
		$e_password = $_POST['txtPassword'];
		if ($e_password == "") {
			$e_password = $pwd;
		} else {
			$e_password = sha1($e_password);
		}

		$pic_name = $_FILES['imgPic']['name'];
		$pic_type = $_FILES['imgPic']['type'];
		$pic_size = $_FILES['imgPic']['size'];
		$pic_tmp_name = $_FILES['imgPic']['tmp_name'];
		//echo "<script>alert('" . $photo . $pic_name . "')</script>";
		if ($pic_name == "") {
			$e_img = $photo;
		} else {
			$dir = $doc_root . "Team6/images/users/$pic_name";
			move_uploaded_file($pic_tmp_name, $dir);
			$e_img = $pic_name;
		}

		$e_role = $_POST['rdoRegRole'];

		$query = "UPDATE user_account SET userName=:e_name, userPassword=:e_password, userEmail=:e_email, userPic=:e_img, userRole=:e_role where userID=$id";
		$parse = oci_parse($connection, $query);

		oci_bind_by_name($parse, ":e_name", $e_name);
		oci_bind_by_name($parse, ":e_password", $e_password);
		oci_bind_by_name($parse, ":e_email", $e_email);
		oci_bind_by_name($parse, ":e_img", $e_img);
		oci_bind_by_name($parse, ":e_role", $e_role);

		oci_execute($parse);
		echo "<script>window.location='user_list.php'</script>";
	}

}
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>

		<?php
		include ($doc_root . '/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>Profile Edit</h2>
			<div class="row">
				<div class="col-md-8">
					<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-sm-2 control-label">Fullname</label>
							<div class="col-sm-10">
								<input class="form-control input-sm" value="<?php echo $name; ?>" name="txtName" type="text" required="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Email ID</label>
							<div class="col-sm-10">
								<input class="form-control input-sm" value="<?php echo $email; ?>" name="txtEmail" type="email" required="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input id="pwd" class="form-control input-sm" value="" placeholder="Leave this field empty if you do not wish to change your password" name="txtPassword" type="password"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Account Picture</label>
							<div class="col-sm-10">
								<input class="input-sm" name="imgPic" type="file" />
								<img height="200" src="http://quiet-ravine-14266.herokuapp.com/images/users/<?php echo $photo; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">Role</label>
							<div class="col-lg-10">
								<div class="radio">
									<label>
										<input type="radio" <?php
										if ($role == "") {echo "checked";
										}
										?> name="rdoRegRole" value="Customer" checked>
										Customer</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" <?php
										if ($role == "Trader") {echo "checked";
										}
										?> name="rdoRegRole" value="Trader">
										Trader</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" <?php
										if ($role == "Admin") {echo "checked";
										}
										?> name="rdoRegRole" value="Admin">
										Admin</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<button name="btnEditProfile" class="btn btn-default">
									Save
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>

	</body>

</html>
