<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
$entrymsg = "";
if (isset($_POST['btnSendNotif'])) {
	$reciever = $_POST['ddReciever'];
	$message = $_POST['txtMessage'];
	$type = "Notification";
	$sender = "";
	$query = "SELECT * FROM user_account where userID=" . $_SESSION['userid'] . "";
	$parse = oci_parse($connection, $query);

	oci_execute($parse);
	while ($row = oci_fetch_assoc($parse)) {
		$sender = $row['USERID'];
	}
	$entrymsg = sendmessage($connection, $sender, $reciever, $message, $type);
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
			<h2>Compose Notification</h2>
			<div class="col-md-10">
				<?php echo $entrymsg; ?>
				<form class="form-horizontal" method="post" action="">
					<div class="form-group">
						<label class="col-sm-2 control-label">Send to</label>
						<div class="col-sm-10">
							<select name="ddReciever" class="form-control input-sm">
								<option value="">--Select Reciever--</option>
								<?php
								$query = "SELECT * FROM user_account where userID!=" . $_SESSION['userid'] . "";
								$parse = oci_parse($connection, $query);
								oci_execute($parse);
								while ($row = oci_fetch_assoc($parse)) {
									echo "<option value=" . $row['USERID'] . ">" . $row['USEREMAIL'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Message</label>
						<div class="col-sm-10">
							<textarea placeholder="Your text here." class="form-control input-sm" name="txtMessage" cols="80" rows="6"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnSendNotif" type="submit" class="btn btn-default btn-sm">
								Send as Notification
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>
