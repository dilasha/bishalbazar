<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/t_head.php');
$query = "SELECT * FROM message m, user_account u where m.msgReciever=u.userID and u.userID=" . $_SESSION['userid'] . "";
$parse = oci_parse($connection, $query);
oci_execute($parse);
?>
<!DOCTYPE html>
<html>
	<head></head>

	<body>

		<?php
		include ($doc_root . '/includes/t_navigation.php');
		?>
		<div class="content row">
			<h2>View Messages</h2>
			<div class="col-md-10">

				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th>Notifications</th>
							<th>Delete</th>
						</thead>
						<?php
						while ($row = oci_fetch_assoc($parse)) {
							echo "<tr><td>" . $row['MSGTEXT'] . "</td><td><a class='link' href='notif_delete.php?id=" . $row['MSGID'] . "'>Delete</a></td></tr>";
						}
						?>
					</table>
				</div>
			</div>
		</div>

	</body>

</html>
