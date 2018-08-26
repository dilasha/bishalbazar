<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$entrymsg = "";
$query = "SELECT * FROM message where msgType='Message'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
?>

<!DOCTYPE html>
<html>
	<head></head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>View Messages</h2>
			<div class="col-md-10">
				<div class="table-responsive">
					<table class="table table-condensed">
						<tr>
							<th>S.N</th>
							<th>Sender</th>
							<th>Reciever</th>
							<th>Message</th>
							<th>Type</th>
							<th>Delete</th>
						</tr>
						<?php
						$c = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$c++;
							echo "<tr>";
							echo "<td>" . $c . "</td>";
							echo "<td>" . $row['MSGSENDER'] . "</td>";
							echo "<td>" . $row['MSGRECIEVER'] . "</td>";
							echo "<td>" . $row['MSGTEXT'] . "</td>";
							echo "<td>" . $row['MSGTYPE'] . "</td>";
							echo "<td><a class='link' href='message_delete.php?id=" . $row['MSGID'] . "'>Delete</a></td>";
							echo "</tr>";
						}
						?>
					</table>
				</div>
			</div>
		</div>

	</body>

</html>
