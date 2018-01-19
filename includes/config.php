<?php
	ob_start();
	session_start();

	$timezone = date_default_timezone_set("Europe/Bucharest");

	$con = mysqli_connect("localhost", "root", "3265", "magazin_online");

	if(mysqli_connect_errno()) {
		echo "Failed to connect: " . mysqli_connect_errno();
	}
?>
