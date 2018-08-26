<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/Team6/includes/head.php');

if (!isset($_SESSION['user'])) {
	echo "<script>alert('You do not have permission to acces this page.')</script>";
	echo "<script>window.location='http://localhost/Team6/login_register.php'</script>";
} else {
	$uID = $_SESSION['userid'];
	$query = "select p.prodID, c.custID, p.prodName, p.prodRate, c.quantity from c_order c, user_account u, product p, shop s
where c.prodID=p.prodID and s.shopID=p.shopID and c.shopID=s.shopID and u.userID=s.userID and c.custID=$uID";
	$parse = oci_parse($connection, $query);
	oci_execute($parse);
	$c = 0;
	$total = 0;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="http://localhost/Team6/css/carousel.css" /></head>

	<body>
		<?php
		include ($doc_root . '/Team6/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://localhost/Team6/index.php">Home</a>
				</li>
				<li class="active">
					Cart
				</li>
			</ul>
			<h3>Confirm Checkout</h3>
			<div class="content">
				<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<thead>
							<th>S.N</th>
							<th>Item</th>
							<th>Rate</th>
							<th>Quantity</th>
							<th>Amount</th>
						</thead>
						<?php
						$arrProdName = array();
						$arrProdAmt = array();
						$arrProdQuantity = array();
						while ($row = oci_fetch_assoc($parse)) {
							echo "<tr>";
							$c++;
							echo "<td>" . $c . "</td>";
							echo "<td>" . $row['PRODNAME'] . "</td>";
							echo "<td>$" . $row['PRODRATE'] . "</td>";
							echo "<td>" . $row['QUANTITY'] . "</td>";
							$amount = $row['QUANTITY'] * $row['PRODRATE'];
							echo "<td>$" . $amount . "</td>";
							echo "</tr>";
							$total += $amount;

							$nameString = '<input type="hidden" name="item_name_' . $c . '" value="' . $row['PRODNAME'] . '" />';
							$amountString = '<input type="hidden" name="amount_' . $c . '" value="' . $row['PRODRATE'] . '" />';
							$quantityString = '<input type="hidden" name="quantity_' . $c . '" value="' . $row['QUANTITY'] . '" />';

							array_push($arrProdName, $nameString);
							array_push($arrProdQuantity, $quantityString);
							array_push($arrProdAmt, $amountString);
						}
						?>
						<tfoot>
							<th colspan="3"></th>
							<th>Total</th>
							<th><?php echo "$" . $total; ?></th>
						</tfoot>
					</table>
					<a class="btn btn-cart" href='http://localhost/Team6/cart/cart_list.php'><span class="fa fa-reply"></span>  Back To Cart</a>
					<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="_xclick">
							<input type="hidden" name="cmd" value="_cart" />
							<input type="hidden" name="upload" value="1" />
							<input type="hidden" name="business" value="team6merchant@yahoo.com" />
							<input type="hidden" name="currency_code" value="USD" />

							<?php
							foreach ($arrProdName as $value) {
								echo $value;
							}
							foreach ($arrProdAmt as $value1) {
								echo $value1;
							}
							foreach ($arrProdQuantity as $value2) {
								echo $value2;
							}
							 ?>
							<input type="hidden" name="custom" value="<?php echo $_SESSION['userid']; ?>" />
							<input type="hidden" name="return" value= "http://localhost/Team6/cart/paypal_return.php" />
							<input type="hidden" name="cancel_return" value="http://localhost/Team6/cart/paypal_cancel.php" />
							<input class="pull-right" type="image" alt="Make payments with PayPal - it's fast, free and secure!" name="submit" src="http://localhost/Team6/images/paypal.jpg" />
						</form>
				</div>				
			</div>
			<div class="row">
					<h3>Featured</h3>
					<div class="col-md-12">
						<div class="carousel carousel-showmanymoveone slide" id="carousel123">
							<div class="carousel-inner">
								<?php
								$query_c = "SELECT * FROM product where prodFeat='Yes'";
								$parse_c = oci_parse($connection, $query_c);
								oci_execute($parse_c);
								$c = 0;
								while ($row_c = oci_fetch_assoc($parse_c)) {
									if ($c == 0) {
										echo "<div class='item active'>";
									} else {
										echo "<div class='item'>";
									}
									$c++;
									echo "<div class='col-xs-12 col-sm-6 col-md-3'>";
									echo "<table>";
									echo "<tr>";
									echo "<td height='200' colspan='2'><a class='fill' style='height=200px;'  href='http://localhost/Team6/site/product_view.php?id=" . $row_c['PRODID'] . "' >";
									echo "<img style='max-height:200px;'  class='prod-img img-responsive' src='http://localhost/Team6/images/products/" . $row_c['PRODIMG'] . "' /></td></a>";
									echo "</tr>";
									echo "<tr>";
									echo "<td class='prod-title'><a href='http://localhost/Team6/site/product_view.php?id=" . $row_c['PRODID'] . "' >" . $row_c['PRODNAME'] . " </a></td>";
									echo "<td rowspan='2'>";
									echo "<a href='http://localhost/Team6/site/product_view.php?id=" . $row_c['PRODID'] . "' class='btn btn-cart pull-right'>";
									echo "<span class='fa fa-eye'> </span>";
									echo "  View Details";
									echo "</a></td>";
									echo "</tr>";
									echo "<tr>";
									echo " <td class='prod-price'>Price : $" . $row_c['PRODRATE'] . "</td>";
									echo "</tr>";
									echo "</table>";
									echo "</div></div>";
								}
								?>
								</div>
								<a class="left carousel-control" href="#carousel123" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
								<a class="right carousel-control" href="#carousel123" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
							</div>
						</div>
					</div>
		</div>
		<script>
			$(document).ready(function() {
				$('.pgwSlider').pgwSlider();
			}); ( function() {
					// setup your carousels as you normally would using JS
					// or via data attributes according to the documentation
					// http://getbootstrap.com/javascript/#carousel
					$('#carousel123').carousel({
						interval : 2000
					});
					$('#carouselABC').carousel({
						interval : 3600
					});
				}()); ( function() {
					$('.carousel-showmanymoveone .item').each(function() {
						var itemToClone = $(this);

						for (var i = 1; i < 4; i++) {
							itemToClone = itemToClone.next();

							// wrap around if at end of item collection
							if (!itemToClone.length) {
								itemToClone = $(this).siblings(':first');
							}

							// grab item, clone, add marker class, add to collection
							itemToClone.children(':first-child').clone().addClass("cloneditem-" + (i)).appendTo($(this));
						}
					});
				}());

			</script>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
