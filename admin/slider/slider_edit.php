<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$sliderID = $_REQUEST['id'];
$query = "SELECT * FROM slider where sliderID='$sliderID'";
$parse = oci_parse($connection, $query);
oci_execute($parse);
while ($row = oci_fetch_assoc($parse)) {
	$editSliderName = $row['SLIDERTITLE'];
	$editSliderImg = $row['SLIDERIMG'];
	$editSliderDesc = $row['SLIDERDESC'];
	$editSliderLink = $row['SLIDERLINK'];
}
if (isset($_POST['btnEditSlider'])) {
	$sliderName = $_POST['txtSliderName'];
	$sliderDesc = $_POST['txtSliderDesc'];
	$sliderLink = $_POST['txtSliderLink'];

	$slider_name = $_FILES['imgSlider']['name'];
	$slider_type = $_FILES['imgSlider']['type'];
	$slider_size = $_FILES['imgSlider']['size'];
	$slider_tmp_name = $_FILES['imgSlider']['tmp_name'];

	if ($slider_name == "") {
		$slider = $editSliderImg;
	} else {
		$dir = $doc_root . "Team6/images/sliders/$slider_name";
		move_uploaded_file($slider_tmp_name, $dir);
		$slider = $slider_name;
	}

	$query_upd = "UPDATE slider SET sliderTitle=:sliderName, sliderLink=:sliderLink , sliderDesc=:sliderDesc , sliderImg=:slider where sliderID='$sliderID'";
	$parse_upd = oci_parse($connection, $query_upd);

	oci_bind_by_name($parse_upd, ":sliderDesc", $sliderDesc);
	oci_bind_by_name($parse_upd, ":sliderName", $sliderName);
	oci_bind_by_name($parse_upd, ":sliderLink", $sliderLink);
	oci_bind_by_name($parse_upd, ":slider", $slider);

	if (oci_execute($parse_upd)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Slider Updated </div>";
		echo "<script>window.location='slider_list.php'</script>";
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
			<div class="col-md-10">
				<h2>Slider Add</h2>
				<div class="col-md-10">
					<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Title</label>
							<div class="col-sm-10">
								<input required value="<?php echo $editSliderName; ?>" name="txtSliderName" placeholder="Slider Title" type="text" class="form-control input-sm">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Information</label>
							<div class="col-sm-10">
								<input required name="txtSliderDesc" value="<?php echo $editSliderDesc; ?>" placeholder="Slider Information" type="text" class="form-control input-sm">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Link</label>
							<div class="col-sm-10">
								<input required name="txtSliderLink" value="<?php echo $editSliderLink; ?>" placeholder="Slider Link" type="text" class="form-control input-sm">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Image</label>
							<div class="col-sm-10">
								<input name="imgSlider" placeholder="Slider Image" type="file" class="input-sm">
								<img src="http://localhost/Team6/images/sliders/<?php echo $editSliderImg; ?>" height=200 />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button name="btnEditSlider" type="submit" class="btn btn-default btn-sm">
									Submit
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>

</html>
