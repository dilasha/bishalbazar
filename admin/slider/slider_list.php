<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/includes/a_head.php');
$entrymsg = "";
$query = "SELECT * FROM slider";
$parse = oci_parse($connection, $query);
oci_execute($parse);
?>

<!DOCTYPE html>
<html>
	<head>
						
		<script language="javascript">
			function ConfirmDelete() {
				return confirm("Do you want to permanently delete this entry?");
			}
			//onclick='return ConfirmDelete()'
		</script>		
	</head>
	<body>

		<?php
		include ($doc_root . '/Team6/includes/a_navigation.php');
		?>
		<div class="content row">
			<h2>Slider List</h2>
			<div class="col-md-10">
				<div class="table-responsive">
					<table class="table table-condensed">
						<tr>
							<th>ID</th>
							<th>Slider Name</th>
							<th>Slider Description</th>
							<th>Slider Image</th>
							<th>Slider Link</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
						<?php
						$c = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$c++;
							echo "<tr>";
							echo "<td>" . $c . "</td>";
							echo "<td>" . $row['SLIDERTITLE'] . "</td>";
							echo "<td>" . $row['SLIDERDESC'] . "</td>";
							echo "<td><img  class='img-responsive' style='max-height:100px;' src='http://quiet-ravine-14266.herokuapp.com/images/sliders/" . $row['SLIDERIMG'] . "'></td>";
							echo "<td>" . $row['SLIDERLINK'] . "</td>";
							echo "<td><a class='link' href='slider_edit.php?id=" . $row['SLIDERID'] . "'>Edit</a></td>";
							echo "<td><a onclick='return ConfirmDelete()' class='link' href='slider_delete.php?id=" . $row['SLIDERID'] . "'>Delete</a></td>";
							echo "</tr>";

						}
						?>
					</table>
				</div>
			</div>
		</div>

	</body>

</html>
