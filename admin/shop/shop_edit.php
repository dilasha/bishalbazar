<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$entrymsg = "";
$editShopName = "";
$editFloorNum = "";
$shopID = $_REQUEST['id'];
$query = "SELECT * FROM shop where shopID='$shopID'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
while ($row = oci_fetch_assoc($parse)) {
	$editShopName = $row['SHOPNAME'];
	$editShopBanner = $row['SHOPIMG'];
	$editFloorNum = $row['FLOORNUM'];
}

if (isset($_POST['btnEditShop'])) {
	$shopName = $_POST['txtShopName'];

	$shopBanner_name = $_FILES['imgShopBanner']['name'];
	$shopBanner_type = $_FILES['imgShopBanner']['type'];
	$shopBanner_size = $_FILES['imgShopBanner']['size'];
	$shopBanner_tmp_name = $_FILES['imgShopBanner']['tmp_name'];

	if ($shopBanner_name == "") {
		$shopBanner = $editShopBanner;
	} else {
		$dir = $doc_root . "Team6/images/shops/$shopBanner_name";
		move_uploaded_file($shopBanner_tmp_name, $dir);
		$shopBanner = $shopBanner_name;
	}

	$floorNum = $_POST['floor'];

	$query_upd = "UPDATE shop SET shopName=:shopName, shopImg=:shopBanner ,floorNum=:floorNum where shopID='$shopID'";
	$parse_upd = oci_parse($connection, $query_upd);

	oci_bind_by_name($parse_upd, ":shopName", $shopName);
	oci_bind_by_name($parse_upd, ":shopBanner", $shopBanner);
	oci_bind_by_name($parse_upd, ":floorNum", $floorNum);

	if (oci_execute($parse_upd)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Shop Updated </div>";
		echo "<script>window.location='shop_list.php'</script>";
	}
}
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2></h2>
			<div class="col-md-10">
				<?php echo $entrymsg; ?>
				<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Shop Name</label>
						<div class="col-sm-10">
							<input required name="txtShopName" value="<?php echo $editShopName; ?>" type="text" class="form-control input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Shop Banner</label>
						<div class="col-sm-10">
							<input name="imgShopBanner" placeholder="Shop Banner" type="file" class="input-sm">
							<img src="http://quiet-ravine-14266.herokuapp.com/images/shops/<?php echo $editShopBanner; ?>" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Floor Number</label>
						<div class="col-sm-10">
							<select class="form-control input-sm" required name="floor">
								<option value="">-Select Floor-</option>
								<option <?php
								if ($editFloorNum == 0) {echo "selected";
								}
								?> value="0">0</option>
								<option <?php
								if ($editFloorNum == 1) {echo "selected";
								}
								?> value="1">1</option>
								<option <?php
								if ($editFloorNum == 2) {echo "selected";
								}
								?> value="2">2</option>
								<option <?php
								if ($editFloorNum == 3) {echo "selected";
								}
								?> value="3">3</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnEditShop" type="submit" class="btn btn-default btn-sm">
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>
