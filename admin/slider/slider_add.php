<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/includes/a_head.php');
$entrymsg = "";
if (isset($_POST['btnAddSlider'])) {
	$sliderName = $_POST['txtSliderName'];
	$sliderDesc = $_POST['txtSliderDesc'];
	$sliderLink = $_POST['txtSliderLink'];

	$slider = "";
	$slider_name = $_FILES['imgSlider']['name'];
	$slider_type = $_FILES['imgSlider']['type'];
	$slider_size = $_FILES['imgSlider']['size'];
	$slider_tmp_name = $_FILES['imgSlider']['tmp_name'];

	if ($slider_name == "") {
		$slider = "slider.jpg";
	} else {
		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		$dir = $doc_root . "Team6/images/sliders/" . $slider_name;
		move_uploaded_file($slider_tmp_name, $dir);
		$slider = $slider_name;
	}
	$query = "INSERT INTO slider VALUES(sliderSeq.nextval, :sliderDesc,:sliderName, :sliderLink ,:slider)";
	$parse = oci_parse($connection, $query);

	oci_bind_by_name($parse, ":sliderDesc", $sliderDesc);
	oci_bind_by_name($parse, ":sliderName", $sliderName);
	oci_bind_by_name($parse, ":sliderLink", $sliderLink);
	oci_bind_by_name($parse, ":slider", $slider);

	if (oci_execute($parse)) {
		$entrymsg = "<div class='alert alert-success'><span class='fa fa-check'></span> Slider Added </div>";
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
			<div class="col-md-10">
				<h2>Slider Add</h2>
				<div class="col-md-10">
					<?php echo $entrymsg; ?>
					<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Title</label>
							<div class="col-sm-10">
								<input required name="txtSliderName" placeholder="Slider Title" type="text" class="form-control input-sm">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Information</label>
							<div class="col-sm-10">
								<input required name="txtSliderDesc" placeholder="Slider Information" type="text" class="form-control input-sm">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Link</label>
							<div class="col-sm-10">
								<input required name="txtSliderLink" placeholder="Slider Link" type="text" class="form-control input-sm">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Slider Image</label>
							<div class="col-sm-10">
								<input name="imgSlider" required placeholder="Shop Banner" type="file" class="input-sm">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button name="btnAddSlider" type="submit" class="btn btn-default btn-sm">
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
