<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		include ($doc_root . '/Team6/includes/head.php');
		if (!isset($_SESSION['user'])) {
			echo "<script>alert('You do not have permission to acces this page.')</script>";
			echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
		}
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

				$e_img = "userPic.jpg";

				$pic_name = $_FILES['imgPic']['name'];
				$pic_type = $_FILES['imgPic']['type'];
				$pic_size = $_FILES['imgPic']['size'];
				$pic_tmp_name = $_FILES['imgPic']['tmp_name'];

				if ($pic_name == "") {
					$e_img = "userPic.jpg";
				} else {
					$dir = $doc_root . "Team6/images/users/$pic_name";
					move_uploaded_file($pic_tmp_name, $dir);
					$e_img = $pic_name;
				}

				$query = "UPDATE user_account SET userName=:e_name, userPassword=:e_password, userEmail=:e_email, userPic=:e_img where userID=$id";
				$parse = oci_parse($connection, $query);

				oci_bind_by_name($parse, ":e_name", $e_name);
				oci_bind_by_name($parse, ":e_password", $e_password);
				oci_bind_by_name($parse, ":e_email", $e_email);
				oci_bind_by_name($parse, ":e_img", $e_img);

				oci_execute($parse);
				echo "<script>window.location='customer_profile.php'</script>";
			}

		}
		?>
	</head>

	<body>
		<?php
		include ($doc_root . '/Team6/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
				</li>
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/customer/customer_profile.php">Profile</a>
				</li>
				<li class="active">
					Profile Edit
				</li>
			</ul>
			<h3>Profile Edit</h3>
			<div class="content">
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
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<button name="btnEditProfile" class="btn btn-cart">
								<span class="fa fa-save"></span> Save Changes
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
