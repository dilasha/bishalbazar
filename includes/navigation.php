<nav class="navbar navbar-inverse">

	<div class="container-fluid">

		<ul class="nav navbar-nav">
			<?php
			if (isset($_SESSION['user'])) {
				echo "<li><a class='greet'>Hello," . $_SESSION['user'] . "!</a></li>";
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/cart/cart_list.php'>Cart  <span class='fa fa-shopping-cart'></span></a></li>";
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/customer/purchase_history.php'>Purchase History  <span class='fa fa-clock-o'></span></a></li>";

			} else {
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/login_register.php'>SIGN IN | REGISTER</a></li>";
			}
			?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php
			if (isset($_SESSION['user'])) {

				$queryC = "SELECT COUNT(msgID) AS CCOUNT FROM MESSAGE WHERE msgReciever=" . $_SESSION['userid'] . "";
				$parseC = oci_parse($connection, $queryC);
				oci_execute($parseC);
				oci_fetch($parseC);
				$totalN = oci_result($parseC, "CCOUNT");

				echo "<li>";
				echo " <a href='http://quiet-ravine-14266.herokuapp.com/customer/customer_notification.php'>Notifications  (" . $totalN . " new) <span class='fa fa-bell'></span></a>";
				echo "</li>";
				echo "<li>";
				echo " <a href='http://quiet-ravine-14266.herokuapp.com/customer/customer_profile.php'>Your Profile  <span class='fa fa-file-text'></span></a>";
				echo "</li>";
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/logout.php'>LOGOUT  <span class='fa fa-sign-out'></span></a></li>";
			} else {
				echo "<li>";
				echo " <a href='http://quiet-ravine-14266.herokuapp.com/admin/admin_login.php'>Are you an Admin?</a>";
				echo "</li>";

			}
			?>
		</ul>
	</div><!-- /.container-fluid -->
</nav>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="http://quiet-ravine-14266.herokuapp.com/index.php"><img src="http://quiet-ravine-14266.herokuapp.com/images/logo.png"></a>

		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/site/about.php">ABOUT</a>
				</li>
				<li class="dropdown">
					<a href="http://quiet-ravine-14266.herokuapp.com/site/floors.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">FLOORS<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="http://quiet-ravine-14266.herokuapp.com/site/floors.php?floor=0">Ground Floor</a>
						</li>
						<li>
							<a href="http://quiet-ravine-14266.herokuapp.com/site/floors.php?floor=1">First Floor</a>
						</li>
						<li>
							<a href="http://quiet-ravine-14266.herokuapp.com/site/floors.php?floor=2">Second Floor</a>
						</li>
						<li>
							<a href="http://quiet-ravine-14266.herokuapp.com/site/floors.php?floor=3">Third Floor</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/site/shop.php">SHOP ALL</a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">PRODUCTS<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<?php
						$query_cat = "SELECT * FROM category";
						$parse_cat = oci_parse($connection, $query_cat);
						oci_execute($parse_cat);
						while ($row = oci_fetch_assoc($parse_cat)) {
							echo "<li>";
							echo "<a href='http://quiet-ravine-14266.herokuapp.com/site/shop.php?id=" . $row['CATID'] . "&catName=" . $row['CATNAME'] . "'>" . $row['CATNAME'] . "</a>";
							echo "</li>";
						}
						?>
					</ul>
				</li>

			</ul>
			<form class="navbar-form navbar-right" method="post" action="http://quiet-ravine-14266.herokuapp.com/site/search.php" >
				<div class="input-group input-group-sm">
					<input type="text" required name="txtKeyword" class="form-control search-inp" placeholder="Search">
					<span class="input-group-btn">
						<button name="btnSearchKey" class="btn btn-default search-btn" type="button">
							<i class="fa fa-search"></i>
						</button> </span>
				</div>
			</form>

			<ul class="nav navbar-nav navbar-right">

				<li>
					<a href="https://www.facebook.com/bishalbazar"><span class="fa fa-facebook"></span></a>
				</li>
				<li>
					<a href="https://twitter.com/hashtag/bishalbazaar"><span class="fa fa-twitter"></a>
				</li>
				<li>
					<a href="https://www.pinterest.com/search/?q=bishalbazar"><span class="fa fa-pinterest-p"></a>
				</li>
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/site/contact.php">CONTACT</a>
				</li>
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/site/time_slot.php">TIME SLOT</a>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->

	</div><!-- /.container-fluid -->
</nav>
<script>
	//shows input field on button click
	$(".search-inp").hide();
	$(document).ready(function() {
		$(".search-btn").click(function() {
			$(".search-inp").toggle('slide');
			$(this).closest('div').find('.search-inp').focus();
		});
	});

</script>
