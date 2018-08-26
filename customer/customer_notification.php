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
			echo "<script>window.location='http://localhost/Team6/login_register.php'</script>";
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
					<a href="http://localhost/Team6/index.php">Home</a>
				</li>
				<li class="active">
					Notification
				</li>
			</ul>
			<h3>Notifications</h3>
			<div class="content row">
				<table class="table table-bordered">
					<?php
					$query = "SELECT * FROM message where msgReciever=" . $_SESSION['userid'] . " ORDER BY msgID DESC";
					$parse = oci_parse($connection, $query);
					oci_execute($parse);
					while ($row = oci_fetch_assoc($parse)) {
						echo "<tr><td>" . $row['MSGTEXT']."</td>";
						echo "<td> <span class='date'>" . $row['MSGTIME'] . "</span></td>";
						echo "<td><a href='notif_delete.php?id=" . $row['MSGID'] . "'>Delete</a</td></tr>";
					}
					?>
				</table>

			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
