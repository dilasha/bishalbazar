<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
$entrymsg = "";
$editCatName = "";
$editCatDesc = "";
$catID = $_REQUEST['id'];
$query = "SELECT * FROM category where catID='$catID'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
while ($row = oci_fetch_assoc($parse)) {
	$editCatName = $row['CATNAME'];
	$editCatDesc = $row['CATDESC'];
}

if (isset($_POST['btnEditCat'])) {
	$catName = $_POST['txtCatName'];
	$catDesc = $_POST['txtCatDesc'];
	$query_upd = "UPDATE category SET catName=:catName, catDesc=:catDesc where catID='$catID'";

	$parse_upd = oci_parse($connection, $query_upd);

	oci_bind_by_name($parse_upd, ":catName", $catName);
	oci_bind_by_name($parse_upd, ":catDesc", $catDesc);

	if (oci_execute($parse_upd)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Category Updated </div>";
		echo "<script>window.location='category_list.php'</script>";
	}
}
?>

<!DOCTYPE html>
<html>
	<head></head>
	<body>

		<?php
		include ($doc_root . '/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>Category Edit</h2>
			<div class="col-md-10">
				<?php echo $entrymsg; ?>
				<form class="form-horizontal" method="post" action="">
					<div class="form-group">
						<label class="col-sm-2 control-label">Category Name</label>
						<div class="col-sm-10">
							<input required name="txtCatName" value="<?php echo $editCatName ?>" type="text" class="form-control input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Category Description</label>
						<div class="col-sm-10">
							<textarea class="form-control input-sm" name="txtCatDesc" cols="80" rows="6"><?php echo $editCatDesc ?> </textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnEditCat" type="submit" class="btn btn-default btn-sm">
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>
