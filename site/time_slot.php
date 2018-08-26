<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		include ($doc_root . '/Team6/includes/head.php');
		?>
	</head>

	<body>
		<?php
		include ($doc_root . '/Team6/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
				</li>
				<li class="active">
					Time Slot
				</li>
			</ul>

			<div class="content">

				<h3>Time Slot</h3>
				<div class="col-md-5">
					<img src="http://quiet-ravine-14266.herokuapp.com/images/slot.jpg" class="img-responsive" />
				</div>
				<div class="col-md-5 col-md-offset-1">
					<p>
						Note: If you make a payment during non working hours, your time slot wll be shifted to the next available slot. This might be the 10:00 AM the next day if you pay after working hours and 10:00 AM of the day you checked out if it was done before working hours.
					</p>
					<p>
						After you make your payment online, you are given a time slot. Within this time slot, you are required to
						collect your purchase from the 'Goods Counter' located in the ground floor of Bishal Bazar complex.
					</p>
					<p>
						The Goods Counter office is open from 10:00 am to 6:00 pm daily.
					</p>

				</div>
			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
