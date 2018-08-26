<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'];
include ($doc_root . '/Team6/connect.php');
include ($doc_root . '/includes/head.php');
$condition = "";
$title = "";
if (isset($_REQUEST['id'])) {
	$prodCat = $_REQUEST['id'];
	$condition = " AND prodCategory=$prodCat";
	$title = "Shop Category : " . $_REQUEST['catName'];
} elseif (isset($_REQUEST['shopid'])) {
	$shopid = $_REQUEST['shopid'];
	$condition = " AND p.shopID=$shopid";
	$title = "Shop : " . $_REQUEST['shopname'];
} else {
	$condition = "";
	$title = "";
}
$selection = "<label>Filter: </label> Products";
$query = "SELECT * FROM product p, category c, shop s, user_account u where c.catID=p.prodCategory and s.userID=u.userID and  s.shopID=p.shopID" . $condition;
if (isset($_POST['btnFilter'])) {
	$queryCat = "SELECT * FROM CATEGORY ORDER BY catName asc";
	$parseCat = oci_parse($connection, $queryCat);
	if ($rowCat = oci_execute($parseCat)) {
		$c = 0;
		$query .= " and ( 1=1 ";
		while ($rowCat = oci_fetch_assoc($parseCat)) {
			if ($c < 1) {
				$op = " and ";
			} else {
				$op = " or ";
			}
			$val = "chkCat" . $rowCat['CATID'];
			if (isset($_POST[$val])) {
				if ($_POST[$val] == "checked") {
					$c++;
					$query .= $op . " p.prodCategory=" . $rowCat['CATID'] . "";
					$selection .= "<br/><label>Category: </label> " . $rowCat['CATNAME'];
				}
			}
		}
		$query .= " ) ";
	}
	$c = 0;
	if ($c < 1) {
		$op = " and";
	} else {
		$op = " or";
	}
	if (isset($_POST['ddSeller'])) {
		$seller = $_POST['ddSeller'];
		if ($seller != "") {
			$query .= $op . " u.userID =" . $seller;
			$querySeller = "select * from user_account where userID=$seller";
			$parseSeller = oci_parse($connection, $querySeller);
			if (oci_execute($parseSeller)) {
				while ($rowSeller = oci_fetch_assoc($parseSeller)) {
					$userName = $rowSeller['USERNAME'];
				}
				$selection .= "<br /><label>Seller:</label> " . $userName;
			}
		}

	} else {

	}
	$c = 0;
	if ($c < 1) {
		$op = " and";
	} else {
		$op = " or";
	}
	if (isset($_POST['chkFeat'])) {
		$yes = "Yes";
		$query .= $op . " p.prodFeat ='$yes' ";
		$selection .= "<br /><label>Featured Only</label>";
	} else {

	}
	if (isset($_POST['ddSort'])) {
		$sort = $_POST['ddSort'];
		if ($sort == "1") {
			$sorter = "prodID DESC";
			$selection .= "<br/><label>Sorted By: </label>  Newest <span class='fa fa-long-arrow-down'></span>";
		} elseif ($sort == "2") {
			$sorter = "prodRate ASC";
			$selection .= "<br/><label>Sorted By: </label>  Price <span class='fa fa-long-arrow-down'></span>";

		} elseif ($sort == "3") {
			$sorter = "prodRate DESC";
			$selection .= "<br/><label>Sorted By: </label>  Price <span class='fa fa-long-arrow-up'></span>";

		} else {
			$sorter = "prodID ASC";
		}
		$query .= " ORDER BY " . $sorter;
	}
}
//echo $query;
$parse = oci_parse($connection, $query);
oci_execute($parse);
?>
<!DOCTYPE html>
<html>
	<head></head>

	<body>
		<?php
		include ($doc_root . '/includes/navigation.php');
		?>
		<div class="container">
			<ul class="breadcrumb">
				<li>
					<a href="http://quiet-ravine-14266.herokuapp.com/index.php">Home</a>
				</li>
				<li class="active">
					<?php
					echo $title;
					?>
				</li>
			</ul>

			<h3> <?php
			echo $title;
		?>
			</h3>
			<div class="content row">
				<div class="col-md-3">
					<form class="form" method="post" action="">
						<div class="form-group">
							<label> Category </label>
							<br />
							<?php
							$queryCat = "SELECT * FROM CATEGORY ORDER BY catName asc";
							$parseCat = oci_parse($connection, $queryCat);
							if ($rowCat = oci_execute($parseCat)) {
								while ($rowCat = oci_fetch_assoc($parseCat)) {
									echo "<input value='checked' name='chkCat" . $rowCat['CATID'] . "' type='checkbox' />   " . $rowCat['CATNAME'] . "<br />";
								}
							}
							?>
						</div>
						<div class="form-group">
							<select name="ddSeller" class="form-control input-sm">
								<option value="">- Seller -</option>
								<?php
								$querySell = "SELECT * FROM shop s, user_account u where u.userID=s.userID and u.userStatus='Verified'";
								$parseSell = oci_parse($connection, $querySell);
								oci_execute($parseSell);
								while ($rowSell = oci_fetch_assoc($parseSell)) {
									echo "<option value=" . $rowSell['USERID'] . ">" . $rowSell['USERNAME'] . "</option>";
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>
								<input name="chkFeat" type='checkbox' />
								Featured only</label>
						</div>
						<div class="form-group">
							<select name="ddSort" class="form-control input-sm">
								<option value="">- Sort -</option>
								<option value="1">Newest </option>
								<option value="2">Price: (Low to High) </option>
								<option value="3">Price: (High to Low) </option>
							</select>
						</div>
						<div class="form-group pull-right">
							<button name="btnFilter" class="btn btn-cart">
								<span class="fa fa-filter"></span> Filter
							</button>
						</div>
					</form>
					<?php echo $selection; ?>
				</div>
				<div class="col-md-9">
					<div class="row">
						<?php
						$products = 0;
						while ($row = oci_fetch_assoc($parse)) {
							$products++;
							echo "<div class='col-md-4'>";
							echo "<table>";
							echo "<tr>";
							echo "<td colspan='2'><a href='http://quiet-ravine-14266.herokuapp.com/site/product_view.php?id=" . $row['PRODID'] . "' >";
							echo "<div class='fill'><img class='img-responsive prod-img' src='http://quiet-ravine-14266.herokuapp.com/images/products/" . $row['PRODIMG'] . "' /></div></a></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td class='prod-title'><a href='http://quiet-ravine-14266.herokuapp.com/site/product_view.php?id=" . $row['PRODID'] . "' >" . $row['PRODNAME'] . " </a></td>";
							echo "<td rowspan='2'>";
							echo "<a href='http://quiet-ravine-14266.herokuapp.com/site/product_view.php?id=" . $row['PRODID'] . "' class='btn btn-cart pull-right'>";
							echo "<span class='fa fa-eye'> </span>";
							echo "  View Details";
							echo "</a></td>";
							echo "</tr>";
							echo "<tr>";
							echo " <td class='prod-price'>Price : $" . $row['PRODRATE'] . "</td>";
							echo "</tr>";
							echo "</table>";
							echo "</div>";
						}
						if ($products == 0) {
							echo "<h5 class='alert alert-danger'><span class='fa  fa-exclamation-circle'></span>  Oops, There were no products to match your preferences.<h5>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
		include ($doc_root . '/includes/footer.php');
		?>
	</body>

</html>
