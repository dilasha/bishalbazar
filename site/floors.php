<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
if (isset($_REQUEST['floor'])) {
	$floor = $_REQUEST['floor'];
	if ($floor == 0) {
		$floorname = "Ground Floor";
	} elseif ($floor == 1) {
		$floorname = "First Floor";
	} elseif ($floor == 2) {
		$floorname = "Second Floor";
	} elseif ($floor == 3) {
		$floorname = "Third Floor";
	}
	$query = "SELECT * FROM shop WHERE floorNum=$floor";
	$parse = oci_parse($connection, $query);
	oci_execute($parse);
} else {
	$url = "http://localhost/Team6/index.php";
	echo "<script>window.location='" . $url . "';</script>";
}
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
					<a href="http://localhost/Team6/index.php">Home</a>
				</li>
				<li class="active">
					Floor : <?php echo $floorname; ?>
				</li>
			</ul>
			<h3><?php echo $floorname; ?></h3>
			<div class="content row">
				<?php
				while ($row = oci_fetch_assoc($parse)) {
					echo "<div class='col-md-6 shop-div'><table class='shop-table'>";
					echo "<tr><td class='prod-title'><a href='#'>".$row['SHOPNAME']."</a></td></tr>";
					echo "<tr><td height='150' class='prod-img fill'><a href='http://localhost/Team6/site/shop.php?shopid=".$row['SHOPID']."&shopname=".$row['SHOPNAME']."'><img class='img-responsive' src='http://localhost/Team6/images/shops/".$row['SHOPIMG']."'></a></td></tr>";
					echo "</table></div>";
				}
				?>		
				
			</div>
		</div>
		<?php
		include ($doc_root . '/Team6/includes/footer.php');
		?>
	</body>

</html>
