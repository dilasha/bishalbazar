<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/t_head.php');
$entrymsg = "";
if (isset($_POST['btnAddShop'])) {
	if (isset($_POST['btnAddShop'])) {
		$shopName = $_POST['txtShopName'];

		$shopBanner = "";
		$shopBanner_name = $_FILES['imgShopBanner']['name'];
		$shopBanner_type = $_FILES['imgShopBanner']['type'];
		$shopBanner_size = $_FILES['imgShopBanner']['size'];
		$shopBanner_tmp_name = $_FILES['imgShopBanner']['tmp_name'];

		if ($shopBanner_name == "") {
			$shopBanner = "shopBanner.jpg";
		} else {
			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$dir = $doc_root . "Team6/images/shops/" . $shopBanner_name;
			move_uploaded_file($shopBanner_tmp_name, $dir);
			$shopBanner = $shopBanner_name;
		}

		$shopFloor = $_POST['floor'];
		$uID = $_SESSION['userid'];
		$shopStatus = "Unverified";
	}

	$query = "INSERT INTO shop VALUES(shopSeq.nextval,$uID ,:shopName,:shopBanner,:shopFloor,:shopStatus)";
	$parse = oci_parse($connection, $query);

	oci_bind_by_name($parse, ":shopName", $shopName);
	oci_bind_by_name($parse, ":shopBanner", $shopBanner);
	oci_bind_by_name($parse, ":shopFloor", $shopFloor);
	oci_bind_by_name($parse, ":shopStatus", $shopStatus);
	if (oci_execute($parse)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Shop verification request sent. </div>";
	}
}
?>
<!DOCTYPE html>
<html>
	<head></head>

	<body>

		<?php
		include ($doc_root . '/includes/t_navigation.php');
		?>
		<div class="content">
			<h2>Shop Add</h2>
			<div class="col-md-10">
				<?php echo $entrymsg; ?>
				<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Shop Name</label>
						<div class="col-sm-10">
							<input required name="txtShopName" placeholder="Shop Name" type="text" class="form-control input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Shop Banner</label>
						<div class="col-sm-10">
							<input name="imgShopBanner" placeholder="Shop Banner" type="file" class="input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Floor Number</label>
						<div class="col-sm-10">
							<select class="form-control input-sm" required name="floor">
								<option value="">-Select Floor-</option>
								<option value="0">0</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnAddShop" type="submit" class="btn btn-default btn-sm">
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>

