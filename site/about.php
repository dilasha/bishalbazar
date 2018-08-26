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
					About
				</li>
			</ul>

			<div class="content row">

				<div class="col-md-5">
					<h3>About</h3>
					<p>
						Bishal Bazaar Company Limited is  Kathmandu's oldest shopping center.
						Constructed in 1969, It has more than 100 shops in 4 floors selling a variety of goods.
						It is said to be most reliable for selling and buying of Watches and Jewelry.
					</p>
					<p>

					</p>
					<p>
						Located in the heart of the city, Bishal Bazaar is the perfect shopping destination for adults and children alike.
						 We believe in great bargains and even better customer service.
					</p>
					<strong> Your favourite shopping center, now online. Happy Shopping!</strong>
				</div>
				<div class="col-md-5 col-sm-offset-1">
					<div class="row">
						<img class="img-responsive front-img" src="../images/about.jpg">
					</div>
				</div>

			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
