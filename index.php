<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
//include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/Team6/includes/head.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="http://localhost/Team6/css/carousel.css" />
	</head>

	<body>
		<?php
		include ($doc_root . '/Team6/includes/navigation.php');
		?>
		<div class="container">
			<div class="content">
				<ul class="pgwSlider">
					<?php
					$query = "SELECT * FROM slider";
					$parse = oci_parse($connection, $query);
					oci_execute($parse);
					while ($row = oci_fetch_assoc($parse)) {
						echo "<li>";
						echo "<a href='" . $row['SLIDERLINK'] . "'>";
						echo "<img style='//height:100%;' data-description='" . $row['SLIDERDESC'] . "' src='http://localhost/Team6/images/sliders/" . $row['SLIDERIMG'] . "' />";
						echo "<span><h2 style='font-size=20px !important;' >" . $row['SLIDERTITLE'] . "</h2></span>";
						echo "</a>";
						echo "</li>";

					}
					?>
				</ul>
			</div>

			<div class="content row">
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
								echo "<td height='200' class='fill' colspan='2'>";
								echo "<img style='max-height:200px;' class='prod-img img-responsive' src='http://localhost/Team6/images/products/" . $row_c['PRODIMG'] . "' /></td>";
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
			<?php
			include ($doc_root . '/Team6/includes/footer.php');
			?>
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
	</body>

</html>
