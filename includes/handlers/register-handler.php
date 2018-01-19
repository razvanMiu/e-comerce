<?php

function sanitizePassword($text) {
	$text = strip_tags($text);
	return $text;
}

function sanitizeString1($text) {
	$text = strip_tags($text);
	$text = str_replace(" ", "", $text);
	return $text;
}

function sanitizeString2($text) {
	$text = strip_tags($text);
	$text = str_replace(" ", "", $text);
	$text = ucfirst(strtolower($text));
	return $text;
}


if(isset($_POST['registerButton'])) {
	//Register button was pressed

	$username 	= sanitizeString1($_POST['username']);
	$firstName 	= sanitizeString2($_POST['firstName']);
	$lastName 	= sanitizeString2($_POST['lastName']);
	$email 			= sanitizeString1($_POST['email']);
	$email2 		= sanitizeString1($_POST['email2']);
	$password 	= sanitizePassword($_POST['password']);
	$password2 	= sanitizePassword($_POST['password2']);
	$adress 		= $_POST['adress'];
	$privilege	=	"Customer";

	$wasSuccesful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2, $adress, $privilege);

	if($wasSuccesful) {
		$_SESSION['userLoggedIn'] = $username;
		$_SESSION['userPrivilege'] = "Customer";
		header("Location: index.php");
	}

}

?>
