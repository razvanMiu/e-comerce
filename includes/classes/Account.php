<?php

class Account {

	private $con;
	private $errorArray;

	public function __construct($con) {
		$this->con = $con;
		$this->errorArray = array();
	}

	public function login($un,$pw) {
		$pw = md5($pw);

		$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

		$queryArray = mysqli_fetch_array($query);
		$_SESSION['userPrivilege'] = $queryArray['privilege'];
		$_SESSION['userID'] = $queryArray['id'];

		if(mysqli_num_rows($query)) {
			return true;
		} else {
			array_push($this->errorArray, Constants::$loginFailed);
			return false;
		}
	}

	public function register($un, $fn, $ln, $em, $em2, $pw, $pw2, $adr, $rights) {
		$this->validateUsername($un);
		$this->validateFirstName($fn);
		$this->validateLastName($ln);
		$this->validateEmails($em, $em2);
		$this->validatePasswords($pw, $pw2);

		if(empty($this->errorArray)) {
			//Insert into DB
			return $this->insertUserDetails($un, $fn, $ln, $em, $pw, $adr, $rights);
		} else {
			return false;
		}
	}

	public function getError($error) {
		if(!in_array($error, $this->errorArray)) {
			$error = "";
		}
		return "<span class='errorMessage'>$error</span>";
	}

	private function insertUserDetails($un, $fn, $ln, $em, $pw, $adr, $rights) {
		$encryptedPw 	= md5($pw);
		$date 			= date("Y-m-d h:i:s");

		$result 		= mysqli_query($this->con, "INSERT INTO users VALUES (default, '$fn', '$ln', '$adr', '$un',  '$em', '$encryptedPw', '$date', '$rights')");

		return $result;
	}

	private function validateUsername($un) {
		if(strlen($un) < 5 || strlen($un) > 25) {
			array_push($this->errorArray,Constants::$usernameCharacters);
			return;
		}

		//TODO: check if username exist
		$checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username = '$un'");
		if(mysqli_num_rows($checkUsernameQuery)) {
			array_push($this->errorArray, Constants::$usernameTaken);
			return;
		}
	}

	private function validateFirstName($fn) {
		if(strlen($fn) < 3 || strlen($fn) > 25) {
			array_push($this->errorArray,Constants::$firstNameCharacters);
			return;
		}

	}

	private function validateLastName($ln) {
		if(strlen($ln) < 3 || strlen($ln) > 25) {
			array_push($this->errorArray,Constants::$lastNameCharacters);
			return;
		}
	}

	private function validateEmails($em, $em2) {
		if($em != $em2) {
			array_push($this->errorArray,Constants::$emailsDoNotMatch);
			return;
		}
		if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, Constants::$emailInvalid);
			return;
		}

		//TODO: check if email exist
		$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email = '$em'");
		if(mysqli_num_rows($checkEmailQuery)) {
			array_push($this->errorArray, Constants::$emailTaken);
			return;
		}
	}

	private function validatePasswords($pw, $pw2) {
		if($pw != $pw2) {
			array_push($this->errorArray,Constants::$passwordsDoNotMatch);
			return;
		}
		if(preg_match('/[^A-Za-z0-9]/' , $pw)) {
			array_push($this->errorArray,Constants::$passwordNotAlphanumeric);
			return;
		}
		if(strlen($pw) < 5 || strlen($pw) > 13) {
			array_push($this->errorArray,Constants::$passwordCharacters);
			return;
		}
	}
}
?>
