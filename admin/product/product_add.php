<?php

$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');

$added = "";
if (isset($_POST['btnProdAdd'])) {
	$prod_cat = $_POST['ddProdCat'];
	$prod_name = $_POST['txtProdName'];
	$prod_price = $_POST['numProdPrice'];
	$prod_pic = "No image";

	$prod_image_name = $_FILES['imgProd']['name'];
	$prod_image_type = $_FILES['imgProd']['type'];
	$prod_image_size = $_FILES['imgProd']['size'];
	$prod_image_tmp_name = $_FILES['imgProd']['tmp_name'];

	if ($prod_image_name == "") {
		echo "<script>alert('You must choose an image for your product.')</script>";
		exit();
	} else {
		$dir = $doc_root . "Team6/images/products/$prod_image_name";
		move_uploaded_file($prod_image_tmp_name, $dir);
		$prod_pic = $prod_image_name;
	}

	$prod_shop = $_POST['ddProdShop'];
	if (isset($_POST['chkProdFeat'])) {
		$prod_feat = "Yes";
	} else {
		$prod_feat = "No";
	}

	$query = "INSERT INTO product VALUES(productSeq.nextVal,:prod_shop,:prod_name,:prod_price,:prod_pic,:prod_cat,:prod_feat)";
	$parse = oci_parse($connection, $query);

	oci_bind_by_name($parse, ":prod_shop", $prod_shop);
	oci_bind_by_name($parse, ":prod_name", $prod_name);
	oci_bind_by_name($parse, ":prod_price", $prod_price);
	oci_bind_by_name($parse, ":prod_pic", $prod_pic);
	oci_bind_by_name($parse, ":prod_cat", $prod_cat);
	oci_bind_by_name($parse, ":prod_feat", $prod_feat);

	oci_execute($parse);
	$added = "<div class='alert alert-success'><span class='fa fa-check'></span> Product Added</div>";

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
			<h2>Add Product</h2>
			<div class="col-md-10">
				<?php echo $added; ?>
				<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label">Product Name</label>
						<div class="col-sm-10">
							<input required name="txtProdName" placeholder="Product Name" type="text" class="form-control input-sm">
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
									echo "<option value='" . $row['SHOPID'] . "'>" . $row['SHOPNAME'] . "</option>";
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
									echo "<option value='" . $row['CATID'] . "'>" . $row['CATNAME'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Product Price</label>
						<div class="col-sm-10">
							<input required name="numProdPrice" placeholder="Product Price" type="number" class="form-control input-sm">
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Product Photo</label>
						<div class="col-sm-10">
							<input name="imgProd" required placeholder="Product Photo" type="file" class="input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div class="checkbox">
								<label>
									<input name="chkProdFeat" type="checkbox">
									Featured </label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnProdAdd" type="submit" class="btn btn-default btn-sm">
								Submit
							</button>
						</div>
					</div>
				</form>

			</div>
		</div>

	</body>
</html>

