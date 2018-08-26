<footer>
	<div class="row">
		<div class="col-md-4">
			<h6>PLEASE SEND US YOUR QUERIES, COMPLAINTS AND SUGGESTIONS. IF ANY.</h6>
			<?php
			if (isset($_POST['btnMessage'])) {
				$sender = $_POST['txtSender'];
				$message = $_POST['txtMessage'];
				$type = "Message";
				$queryR = "SELECT * FROM user_account WHERE userRole='Admin' and userStatus='Verified'";
				$parseR = oci_parse($connection, $queryR);
				oci_execute($parseR);
				while ($row = oci_fetch_assoc($parseR)) {
					$reciever = $row['USERID'];
					$sent = sendmessage($connection, $sender, $reciever, $message, $type);
				}
				if ($sent != "") {
					echo "<script>alert('Your message has been sent to all Admins!')</script>";
				}
			}
			?>

			<form class="form" method="post" action="">
				<div class="form-group">
					<input type="text" name="txtSender" required class="form-control input-sm footer-inp" placeholder="Name">
				</div>
				<div class="form-group">
					<textarea required name="txtMessage" class="form-control input-sm footer-inp" placeholder="Message" rows="2"></textarea>
				</div>
				<div class="form-group">
					<button name="btnMessage" class="footer-btn" type="submit">
						<span class="fa fa-send"></span>
					</button>
				</div>
			</form>
		</div>
		<div class="col-md-3 col-md-offset-1">
			<h6>FLOORS</h6>
			<ul class="footer-list">
				<li>
					<a href="#">Ground Floor</a>
				</li>
				<li>
					<a href="#">First Floor</a>
				</li>
				<li>
					<a href="#">Second Floor</a>
				</li>
				<li>
					<a href="#">Third Floor</a>
				</li>
			</ul>
			<h6>TIME SLOT</h6>
			Our customer's can place an order for items online and pick them up from the Shopping center at a given timeslot.
			Hours: 10:00am - 18:00pm daily
		</div>
		<div class="col-md-3 col-md-offset-1">
			<h6>CONTACT</h6>
			<ul class="footer-list">
				<li>
					<span>Location: </span> New Road, Kathmandu
				</li>
				<li>
					<span>Email: </span> info@bishalbazar.com.np
				</li>
				<li>
					<span>Phone: </span> +977 1-4242185
				</li>
			</ul>

		</div>
	</div>
	<div class="row copyright">
		&copy; 2015, Bishal Bazaar Company Ltd.
	</div>
</footer>
