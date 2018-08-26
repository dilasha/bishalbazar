<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$query = "SELECT * FROM user_account where userStatus!='Unverified'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
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
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>User List</h2>
			<div class="col-md-11">
				<table class="table table-condensed">
					<thead>
						<th>S.N</th>
						<th>Photo</th>
						<th>Name</th>
						<th>Email</th>
						<th>Password</th>
						<th>Role</th>
						<th>Status</th>
						<th>Edit</th>
						<th>Deactivate</th>
						<th>Delete</th>
					</thead>
					<?php
					$c = 0;
					while ($row = oci_fetch_assoc($parse)) {
						$c++;
						echo "<tr>";
						echo "<td>" . $c . "</td>";
						echo "<td><img class='img-responsive' style='max-height:100px;' src='http://localhost/Team6/images/users/" . $row['USERPIC'] . "' /></td>";
						echo "<td>" . $row['USERNAME'] . "</td>";
						echo "<td>" . $row['USEREMAIL'] . "</td>";
						echo "<td>" . $row['USERPASSWORD'] . "</td>";
						echo "<td>" . $row['USERROLE'] . "</td>";
						echo "<td>" . $row['USERSTATUS'] . "</td>";
						echo "<td><a class='link' href='http://localhost/Team6/admin/user/user_edit.php?id=" . $row['USERID'] . "'>Edit</a></td>";
						if ($row['USERSTATUS'] == "Deactivated") {
							$url = "http://localhost/Team6/admin/user/user_reactivate.php?id=" . $row['USERID'];
							$text = "Reactivate";
						} else {
							$url = "http://localhost/Team6/admin/user/user_deactivate.php?id=" . $row['USERID'];
							$text = "Deactivate";
						}
						echo "<td><a class='link' href='" . $url . "'>" . $text . "</a></td>";
						echo "<td><a onclick='return ConfirmDelete()' class='link' href='http://localhost/Team6/admin/user/user_delete.php?id=" . $row['USERID'] . "'>Delete</a></td>";
						echo "</tr>";
					}
					?>
				</table>

			</div>
		</div>

	</body>

</html>
