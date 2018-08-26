<?php
function sendmessage($connection, $sender, $reciever, $message, $type) {
	$query = "INSERT INTO message VALUES(messageSeq.nextval,:sender,:reciever, :message, :type, TO_CHAR(SYSDATE,'MONTH DD, YYYY - HH24:MM AM'))";
	$parse = oci_parse($connection, $query);

	oci_bind_by_name($parse, ":sender", $sender);
	oci_bind_by_name($parse, ":reciever", $reciever);
	oci_bind_by_name($parse, ":message", $message);
	oci_bind_by_name($parse, ":type", $type);

	if (oci_execute($parse)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Notification Sent! </div>";
	}
	return $entrymsg;
}
?>