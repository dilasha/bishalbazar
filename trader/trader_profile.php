<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/t_head.php');
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
<!DOCTYPE html>
<html>
	<head>
			<script language="javascript">
				function ConfirmDelete() {
					return confirm("Do you want to permanently delete this entry?");
				}

				//onclick='return ConfirmDelete()'
		</script>
	</head>

	<body>

		<?php
		include ($doc_root . '/Team6/includes/t_navigation.php');
		?>
		<div class="content row">
			<h2>My Profile</h2>

			<div class="col-md-4">
				<img class="img-responsive" src="http://quiet-ravine-14266.herokuapp.com/images/users/<?php echo $photo; ?>" />
			</div>
			<div class="col-md-offset-1 col-md-5">
				<a href="trader_edit.php?id=<?php echo $id; ?>" class="btn btn-default pull-right">Edit Profile</a>
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
						<td><a class="link" href="trader_deactivate.php?id=<?php echo $id; ?>">Deactivate</a></td>
					</tr>
					<tr>
						<th>Delete</th>
						<td><a onclick='return ConfirmDelete()' class="link" href="trader_delete.php?id=<?php echo $id; ?>">Delete Profile</a></td>
					</tr>
				</table>
				
			</div>
		</div>

	</body>

</html>
