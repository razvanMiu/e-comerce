<?php
/*--START SESSIONS--*/
startSessions();


if(isset($_GET['search'])) {
	$_SESSION['search'] = true;

	unset($_SESSION['tablets']);
	unset($_SESSION['smartphones']);

} else if(isset($_GET['tablets'])) {
	$_SESSION['tablets'] = true;

	destroySessions();
	unset($_SESSION['smartphones']);

} else if(isset($_GET['smartphones'])) {
	$_SESSION['smartphones'] = true;

	destroySessions();
	unset($_SESSION['tablets']);
}

if(isset($_SESSION['search'])) {
	$tabletQuery = getSearchQuery($con);
	if(isset($_GET['risingButton'])) {
		$_SESSION['tablets'] = true;
		unset($_SESSION['search']);
		unset($_GET['decreasingButton']);
	} else {
		$_SESSION['tablets'] = true;
		unset($_SESSION['search']);
		unset($_GET['risingButton']);
	}
} else if(isset($_SESSION['tablets'])) {
	if(isset($_GET['risingButton'])) {
		$tabletQuery = getQuery($con, "1", " order by D.price ASC");
		unset($_GET['decreasingButton']);
	} else {
		$tabletQuery = getQuery($con, "1", " order by D.price DESC");
		unset($_GET['risingButton']);
	}
} else if(isset($_SESSION['smartphones'])) {
	$tabletQuery = getQuery($con, "2", " order by D.price DESC");
	unset($_GET['tablets']);
} else {
	$tabletQuery = getQuery($con, "2", " order by D.price DESC");
}

while($row = mysqli_fetch_array($tabletQuery)) {

		$status = getColor($row['stoc']);

		echo "<div class='gridViewItem'>
						<a href='device.php?id=" . $row['id'] ."'>
							<img src='" . $row['path'] . "'>

							<div class='gridViewInfo'>"
								. $row['name'] . "
								<p id='pStocStatus'	style='" . $status[1] . "'>" . $status[0] . "</p>
								<p id='pStoc'>" . $row['stoc'] . " oferte disponibile</p>
								<p id='pPrice'>" . $row['price'] . " Lei</p>
							</div>
						</a>
					</div>";
}
?>
