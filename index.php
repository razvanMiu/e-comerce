<?php
	include("includes/config.php");
	include("includes/classes/Constants.php");
	include("includes/classes/Account.php");
	include("includes/script.php");

	$account = new Account($con);

	include("includes/handlers/login-handler.php");
	$query = mysqli_query($con,"SELECT COUNT(*) as ticketOrder FROM ticket");
	$row = mysqli_fetch_array($query);
	$ticketNumber = $row['ticketOrder'] + 1;
	logoutFunction();
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Hai la Taraba!</title>

		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
		<script src="assets/js/script.js"></script>

	</head>

	<body>

		<?php include("./includes/header.php") ?>
		<?php include("./includes/sidebar.php") ?>
		<?php include("./includes/mainview.php") ?>

	</body>

</html>
