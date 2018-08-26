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
					Contact
				</li>
			</ul>
			<h3>Contact</h3>
			<div class="content row">
				<div class="col-md-6">
					<img src="http://quiet-ravine-14266.herokuapp.com/images/loc.JPG" class="img-responsive" />
				</div>
				<div class="col-md-offset-1 col-md-5">
					<label>Phone: </label>
					<span>+977 1-4242185</span>
					<br />
					<br />
					<label>Email: </label>
					<span>info@bishalbazar.com.np</span>
					<br />
					<br />
					<label>Address:</label>
					<span>New Road, Kathmandu 44600, Nepal</span>
				</div>
			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
