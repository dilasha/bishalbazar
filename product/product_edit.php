<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/t_head.php');
$prodID = $_REQUEST['id'];
$entrymsg = "";
$eProdName = "";
$eProdCat = "";
$eProdImg = "";
$eProdPrice = "";
$eProdShop = "";
$eProdFeat = "";
$query = "SELECT * FROM product where prodID='$prodID'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
while ($row = oci_fetch_assoc($parse)) {
	$eProdName = $row['PRODNAME'];
	$eProdCat = $row['PRODCATEGORY'];
	$eProdImg = $row['PRODIMG'];
	$eProdPrice = $row['PRODRATE'];
	$eProdShop = $row['SHOPID'];
	$eProdFeat = $row['PRODFEAT'];
}
if (isset($_POST['btnProdEdit'])) {
	$editProdName = $_POST['txtProdName'];
	$editProdShop = $_POST['ddProdShop'];
	$editProdCat = $_POST['ddProdCat'];
	$editProdPrice = $_POST['numProdPrice'];
	if (isset($_POST['chkProdFeat'])) {
		$editProdFeat = "Yes";
	} else {
		$editProdFeat = "No";
	}
	$prodImg_name = $_FILES['imgProd']['name'];
	$prodImg_type = $_FILES['imgProd']['type'];
	$prodImg_size = $_FILES['imgProd']['size'];
	$prodImg_tmp_name = $_FILES['imgProd']['tmp_name'];

	if ($prodImg_name == "") {
		$editProdImg = $eProdImg;
	} else {
		$dir = $doc_root . "Team6/images/products/$prodImg_name";
		move_uploaded_file($prodImg_tmp_name, $dir);
		$editProdImg = $prodImg_name;
	}

	$query = "UPDATE PRODUCT SET prodName=:editProdName, prodCategory=:editProdCat, shopID=:editProdShop, prodRate=:editProdPrice, prodFeat=:editProdFeat, prodImg=:editProdImg where prodID='$prodID'";

	$parse = oci_parse($connection, $query);

	oci_bind_by_name($parse, ":editProdName", $editProdName);
	oci_bind_by_name($parse, ":editProdCat", $editProdCat);
	oci_bind_by_name($parse, ":editProdShop", $editProdShop);
	oci_bind_by_name($parse, ":editProdPrice", $editProdPrice);
	oci_bind_by_name($parse, ":editProdFeat", $editProdFeat);
	oci_bind_by_name($parse, ":editProdImg", $editProdImg);

	if (oci_execute($parse)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Product Updated </div>";
		echo "<script>window.location='product_list.php'</script>";
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
		<div class="content row">
			<h2>Product Edit</h2>
			<div class="col-md-10">
				<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
					<?php echo $entrymsg; ?>
					<div class="form-group">
						<label class="col-sm-2 control-label">Product Name</label>
						<div class="col-sm-10">
							<input required name="txtProdName" value="<?php echo $eProdName; ?>" placeholder="Product Name" type="text" class="form-control input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Product Shop</label>
						<div class="col-sm-10">
							<select required  name="ddProdShop" class="form-control input-sm">
								<option>--Select Shop--</option>
								<?php
								$uID = $_SESSION['userid'];
								$query = "SELECT * FROM shop where shopStatus='Verified' and userID=".$_SESSION['userid']."";
								$parse = oci_parse($connection, $query);
								oci_execute($parse);
								while ($row = oci_fetch_assoc($parse)) {
									$sel = "";
									if ($row['SHOPID'] == $eProdShop) {
										$sel = "selected";
									}
									echo "<option " . $sel . " value='" . $row['SHOPID'] . "'>" . $row['SHOPNAME'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Product Category</label>
						<div class="col-sm-10">
							<select required  name="ddProdCat" class="form-control input-sm">
								<option>--Select Category--</option>
								<?php
								$query = "SELECT * FROM category";
								$parse = oci_parse($connection, $query);
								oci_execute($parse);
								while ($row = oci_fetch_assoc($parse)) {
									$sel = "";
									if ($row['CATID'] == $eProdCat) {
										$sel = "selected";
									}
									echo "<option " . $sel . " value='" . $row['CATID'] . "'>" . $row['CATNAME'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Product Price</label>
						<div class="col-sm-10">
							<input required name="numProdPrice" value="<?php echo $eProdPrice; ?>" placeholder="Product Price" type="number" class="form-control input-sm">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Product Photo</label>
						<div class="col-sm-10">
							<input name="imgProd" placeholder="Product Photo" type="file" class="input-sm">
							<img src="http://quiet-ravine-14266.herokuapp.com/images/products/<?php echo $eProdImg ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input
									<?php
									if ($eProdFeat == "Yes") {echo "checked";
									}
									?> name="chkProdFeat" type="checkbox">
									Featured</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnProdEdit" type="submit" class="btn btn-default btn-sm">
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>
