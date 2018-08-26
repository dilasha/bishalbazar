<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		include ($doc_root . '/includes/head.php');
		if (!isset($_SESSION['user'])) {
			echo "<script>alert('You do not have permission to acces this page.')</script>";
			echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/login_register.php'</script>";
		}
		$id = $_SESSION['userid'];
		$query = "SELECT * FROM user_account WHERE userID=$id";
		$parse = oci_parse($connection, $query);
		oci_execute($parse);
		while ($row = oci_fetch_assoc($parse)) {
			$name = $row['USERNAME'];
			$photo = $row['USERPIC'];
			$email = $row['USEREMAIL'];
		}
		?>
		
		<script language="javascript">
			function ConfirmDelete() {
				return confirm("Do you want to permanently delete this entry?");
			}
			//onclick='return ConfirmDelete()'
		</script>
	</head>

	<body>
		<?php
		include ($doc_root . '/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
				</li>
				<li class="active">
					Profile
				</li>
			</ul>
			<h3>Profile</h3>
			<div class="content row">
			<div class="col-md-5">
				<img class="img-responsive" src="http://quiet-ravine-14266.herokuapp.com/images/users/<?php echo $photo; ?>" />
			</div>
			<div class="col-md-7">
				<a href="customer_edit.php?id=<?php echo $id; ?>" class="btn btn-cart pull-right"> <span class="fa fa-edit"></span>  Edit Profile</a>
				<br />
				<br />
				<br />
				<table class="table table-bordered">
					<tr>
						<th>Username</th>
						<td><?php echo $name; ?></td>
					</tr>
					<tr>
						<th>Email</th>
						<td><?php echo $email; ?></td>
					</tr>
					<tr>
						<th>Password</th>
						<td>Hidden for your security</td>
					</tr>
					<tr>
						<th>Deactivate</th>
						<td><a class="link" href="customer_deactivate.php?id=<?php echo $id; ?>">Deactivate</a></td>
					</tr>
					<tr>
						<th>Delete</th>
						<td><a onclick='return ConfirmDelete()' class="link" href="customer_delete.php?id=<?php echo $id; ?>">Delete Profile</a></td>
					</tr>
				</table>
				
			</div>
			</div>
		</div>
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
