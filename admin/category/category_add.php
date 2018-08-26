<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$entrymsg = "";
if (isset($_POST['btnAddCat'])) {
	$catName = $_POST['txtCatName'];
	$catDesc = $_POST['txtCatDesc'];
	$query = "INSERT INTO category VALUES(categorySeq.nextval, :catName, :catDesc)";
	$parse = oci_parse($connection, $query);

	oci_bind_by_name($parse, ":catName", $catName);
	oci_bind_by_name($parse, ":catDesc", $catDesc);

	if (oci_execute($parse)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Category Added </div>";
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
			<h2>Add Category</h2>
			<div class="col-md-10">
				<?php echo $entrymsg; ?>
				<form class="form-horizontal" method="post" action="">
					<div class="form-group">
						<label class="col-sm-2 control-label">Category Name</label>
						<div class="col-sm-10">
							<input required name="txtCatName" placeholder="Category Name" type="text" class="form-control input-sm">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Category Description</label>
						<div class="col-sm-10">
							<textarea placeholder="Category Description" class="form-control input-sm" name="txtCatDesc" cols="80" rows="6"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button name="btnAddCat" type="submit" class="btn btn-default btn-sm">
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</body>

</html>
