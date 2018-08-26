<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$role = '';
?>
<!DOCTYPE html>
<html>
	<head>

		<script language="javascript">
			function ConfirmDelete() {
				return confirm("Do you want to permanently deny this request?");
			}

			//onclick='return ConfirmDelete()'
		</script>
	</head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>User Verification : <?php echo $role; ?></h2>
			<div class="col-md-11">
				<table class="table table-condensed">
					<thead>
						<th>S.N</th>
						<th>Account Picture</th>
						<th>Name</th>
						<th>Email</th>
						<th>Password</th>
						<th>Role</th>
						<th>Status</th>
						<th>Edit</th>
						<th>Delete</th>
					</thead>
					<?php
					if (isset($_REQUEST['role'])) {
						$role = $_REQUEST['role'];
					}else{
						$role="";
					}
					$query = "SELECT * FROM user_account where userStatus = 'Unverified' AND userRole = '$role'";
					$parse = oci_parse($connection, $query);
					oci_execute($parse);

					$c = 0;
					while ($row = oci_fetch_assoc($parse)) {

						$c++;
						echo "<tr>";
						echo "<td>" . $c . "</td>";
						echo "<td><img style='max-height:100px' class='img-responsive' src='http://quiet-ravine-14266.herokuapp.com/images/users/" . $row['USERPIC'] . "' /></td>";
						echo "<td>" . $row['USERNAME'] . "</td>";
						echo "<td>" . $row['USEREMAIL'] . "</td>";
						echo "<td>" . $row['USERPASSWORD'] . "</td>";
						echo "<td>" . $row['USERROLE'] . "</td>";
						echo "<td>" . $row['USERSTATUS'] . "</td>";
						echo "<td><a class='btn btn-success' href='user_confirm.php?id=" . $row['USERID'] . "'>Verify   <span class='fa fa-check-square'></span></a></td>";
						echo "<td><a onclick='return ConfirmDelete()' class='btn btn-danger' href='user_deny.php?id=" . $row['USERID'] . "'>Delete <span class='fa fa-minus-square'></span></a></td>";
						echo "</tr>";
					}
					?>
				</table>

			</div>
		</div>

	</body>

</html>
