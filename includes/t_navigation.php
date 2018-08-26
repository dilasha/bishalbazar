<header>
	<div class="logo">
		<a href="http://localhost/Team6/trader/trad_dash.php"><img src="http://localhost/Team6/images/logo.png" title="Magnetic" alt="Magnetic"/></a>
	</div><!-- end logo -->

	<div id="menu_icon">
		<span class="fa fa-bars fa-2x"></span>
	</div>

	<nav>
		<ul>
			
			<li>
				<a href="http://localhost/Team6/trader/trad_dash.php">Dashboard</a>
			</li>
			<li>
				<a href="http://localhost/Team6/shop/shop_list.php">Shop List</a>
			</li>
			<li>
				<a href="http://localhost/Team6/shop/shop_add.php">Add Shop</a>
			</li>
			<li>
				<a href="http://localhost/Team6/product/product_list.php">Product List</a>
			</li>
			<li>
				<a href="http://localhost/Team6/product/product_add.php">Add Products</a>
			</li>
		</ul>
	</nav><!-- end navigation menu -->

	<div class="footer clearfix">
		<ul class="social clearfix">
			<li>
				<a href="https://www.facebook.com/bishalbazar" class="fa fa-facebook"></a>
			</li>
			<li>
				<a href="https://twitter.com/hashtag/bishalbazaar" class="fa fa-twitter"></a>
			</li>
			<li>
				<a href="https://www.pinterest.com/search/?q=bishalbazar" class="fa fa-pinterest"></a>
			</li>
			<li>
				<a href="#" class="fa fa-rss"></a>
			</li>
		</ul><!-- end social -->

		<div class="rights">
			<p>
				Copyright © 2015 Bishal Bazaar Company Ltd.
			</p>
		</div><!-- end rights -->
	</div ><!-- end footer -->
</header><!-- end header -->

<section class="main clearfix">
	<div class="row pill-row">
		<ul class="nav nav-pills col-md-5">
			<li>
				<?php
				if (isset($_SESSION['user'])) {
					echo "<a href='http://localhost/Team6/trader/trader_profile.php'> " . $_SESSION['user'] . "'s Profile  <span class='fa fa-file-text'></span> </a>";
			$query_notif = "SELECT COUNT(msgID) AS NCOUNT  FROM message m, user_account u where m.msgReciever=u.userID and u.userID=" . $_SESSION['userid'] . "";
			$parse_notif = oci_parse($connection, $query_notif);
			oci_execute($parse_notif);
			oci_fetch($parse_notif);
			$tNotif = oci_result($parse_notif, "NCOUNT");

			echo "<li><a href='http://localhost/Team6/trader/trader_notification.php'>Notifications (".$tNotif." new) <span class='fa fa-bell'></span></a></li>";
			
				}
				?>
			</li>
		</ul>
		<ul class="nav nav-pills navbar-right col-md-2">

			<?php
			if (isset($_SESSION['user'])) {

				echo "<li class='pull-right'><a href='http://localhost/Team6/logout.php'>LOGOUT  <span class='fa fa-sign-out'></span></a></li>";
			
			
			}
			?>
		</ul>

	</div>

	</ul>
