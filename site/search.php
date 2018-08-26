<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/Team6/includes/head.php');
if (!isset($_POST['txtKeyword'])) {
	$keyword = "";
	echo "<script>alert('Sorry, we were unable to process your request. Pleas enter your keyword again')</script>";
	echo "<script>window.location='http://quiet-ravine-14266.herokuapp.com/index.php'</script>";
} else {
	$keyword = $_POST['txtKeyword'];
	$query = "SELECT * FROM product WHERE UPPER(prodName) like UPPER('%$keyword%')";
	$parse = oci_parse($connection, $query);
	oci_execute($parse);
}
?>
<!DOCTYPE html>
<html>
	<head></head>
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
					Search Keyword
				</li>
			</ul>
			<h3>Search results for : <?php echo $keyword; ?>
			</h3>
			<div class="content">
				<div class="row">
					<?php
					while ($row = oci_fetch_assoc($parse)) {

						echo "<div class='col-md-3'>";
						echo "<table>";
						echo "<tr>";
						echo "<td colspan='2'><a href='http://quiet-ravine-14266.herokuapp.com/site/product_view.php?id=" . $row['PRODID'] . "' >";
						echo "<div class='fill'><img class='img-responsive prod-img' src='http://quiet-ravine-14266.herokuapp.com/images/products/" . $row['PRODIMG'] . "' /></div></a></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td class='prod-title'><a href='http://quiet-ravine-14266.herokuapp.com/site/product_view.php?id=" . $row['PRODID'] . "' >" . $row['PRODNAME'] . " </a></td>";
						echo "<td rowspan='2'>";
						echo "<a href='http://quiet-ravine-14266.herokuapp.com/site/product_view.php?id=" . $row['PRODID'] . "' class='btn btn-cart pull-right'>";
						echo "<span class='fa fa-eye'> </span>";
						echo "  View Details";
						echo "</a></td>";
						echo "</tr>";
						echo "<tr>";
						echo " <td class='prod-price'>Price : $" . $row['PRODRATE'] . "</td>";
						echo "</tr>";
						echo "</table>";
						echo "</div>";
					}
					?>
				</div>
			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>
</html>
