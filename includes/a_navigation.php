<header>
	<div class="logo">
		<a href="http://quiet-ravine-14266.herokuapp.com/admin/admin_dash.php"><img src="http://quiet-ravine-14266.herokuapp.com/images/logo.png"></a>
	</div><!-- end logo -->

	<div id="menu_icon">
		<span class="fa fa-bars fa-2x"></span>
	</div>

	<nav>
		<ul>

			<?php
			$query_shop = "SELECT COUNT(shopID) AS SCOUNT FROM shop where shopStatus='Unverified'";
			$parse_shop = oci_parse($connection, $query_shop);
			oci_execute($parse_shop);
			oci_fetch($parse_shop);
			$unv_shop = oci_result($parse_shop, "SCOUNT");

			$query_trader = "SELECT COUNT(userID) AS TCOUNT FROM user_account u where u.userRole='Trader' AND u.userStatus='Unverified'";
			$parse_trader = oci_parse($connection, $query_trader);
			oci_execute($parse_trader);
			oci_fetch($parse_trader);
			$unv_trader = oci_result($parse_trader, "TCOUNT");

			$query_admin = "SELECT COUNT(userID) AS ACOUNT FROM user_account u where u.userRole='Admin' AND u.userStatus='Unverified'";
			$parse_admin = oci_parse($connection, $query_admin);
			oci_execute($parse_admin);
			oci_fetch($parse_admin);
			$unv_admin = oci_result($parse_admin, "ACOUNT");

			$unv_total = $unv_shop + $unv_admin + $unv_trader;
			?>
			<li>
				<a href="#verification" data-toggle="collapse" data-parent="#mainmenu"> Verification Requests <span class="badge  pull-right"><?php echo $unv_total; ?></span></a>
				<ol class="collapse pos-absolute" id="verification">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/shop/shop_verify.php" data-toggle="collapse" data-target="#verification">Shop Verification <span class="badge  pull-right"><?php echo $unv_shop; ?></span></a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/user/user_verify.php?role=Trader" data-toggle="collapse" data-target="#verification"> Trader Verification <span class="badge pull-right"><?php echo $unv_trader; ?></span></a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/user/user_verify.php?role=Admin" data-toggle="collapse" data-target="#verification"> Admin Verification <span class="badge pull-right"><?php echo $unv_admin; ?></span></a>
					</li>
				</ol>
			</li>

			<li>
				<a href="#user" data-toggle="collapse" data-parent="#mainmenu"> Users <i class="fa  fa-angle-down pull-right"></i></a>
				<ol class="collapse pos-absolute" id="user">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/user/user_list.php" data-toggle="collapse" data-target="#user"> View Users</a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/user/user_add.php" data-toggle="collapse" data-target="#user"> Add User</a>
					</li>
				</ol>
			</li>

			<li>
				<a href="#shop" data-toggle="collapse" data-parent="#mainmenu"> Shops <i class="fa  fa-angle-down pull-right"></i></a>
				<ol class="collapse pos-absolute" id="shop">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/shop/shop_list.php" data-toggle="collapse" data-target="#shop"> View Shops</a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/shop/shop_add.php" data-toggle="collapse" data-target="#shop"> Add Shop</a>
					</li>
				</ol>
			</li>

			<li>
				<a href="#category" data-toggle="collapse" data-parent="#mainmenu"> Categories <i class="fa  fa-angle-down pull-right"></i></a>
				<ol class="collapse pos-absolute" id="category">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/category/category_list.php" data-toggle="collapse" data-target="#category"> View Categories</a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/category/category_add.php" data-toggle="collapse" data-target="#category"> Add Category</a>
					</li>
				</ol>
			</li>

			<li>
				<a href="#product" data-toggle="collapse" data-parent="#mainmenu"> Products <i class="fa  fa-angle-down pull-right"></i></a>
				<ol class="collapse pos-absolute" id="product">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/product/product_list.php" data-toggle="collapse" data-target="#product"> View Products</a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/product/product_add.php" data-toggle="collapse" data-target="#product"> Add Product</a>
					</li>
				</ol>
			</li>
			<li>
				<a href="#slider" data-toggle="collapse" data-parent="#mainmenu"> Sliders <i class="fa  fa-angle-down pull-right"></i></a>
				<ol class="collapse pos-absolute" id="slider">
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/slider/slider_list.php" data-toggle="collapse" data-target="#slider"> View Sliders</a>
					</li>
					<li>
						<a href="http://quiet-ravine-14266.herokuapp.com/admin/slider/slider_add.php" data-toggle="collapse" data-target="#slider"> Add Slider</a>
					</li>
				</ol>
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
		<ul class="nav nav-pills col-md-6 ">

			<?php
			$query_msg = "SELECT COUNT(msgID) AS MCOUNT FROM message where msgReciever=" . $_SESSION['userid'] . "";
			$parse_msg = oci_parse($connection, $query_msg);
			oci_execute($parse_msg);
			oci_fetch($parse_msg);
			$total_msg = oci_result($parse_msg, "MCOUNT");

			if (isset($_SESSION['user'])) {
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/admin/admin_profile.php'>" . $_SESSION['user'] . "'s Profile  <span class='fa fa-file-text'></span></a></li>";
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/admin/message/message_view.php'>Messages (".$total_msg." new) <span class='fa fa-comments'></span></a></li>";
				echo "<li><a href='http://quiet-ravine-14266.herokuapp.com/admin/message/message_send.php'>Compose  <span class='fa fa-plus'></span></a></li>";
			}
			?>
		</ul>
		<ul class="nav nav-pills navbar-right col-md-2">
			<?php
			if (isset($_SESSION['user'])) {

				echo "<li class='pull-right' ><a href='http://quiet-ravine-14266.herokuapp.com/logout.php'>LOGOUT  <span class='fa fa-sign-out'></span> </a></li>";
			}
			?>
		</ul>

	</div>

	</ul>
