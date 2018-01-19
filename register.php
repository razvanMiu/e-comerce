<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<title>Hai la taraba</title>

		<link rel="stylesheet" type="text/css" href="assets/css/register.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="assets/js/register.js"></script>
	</head>

	<body>
		<?php
		if(isset($_POST['registerButton'])) {
			echo '<script>
							$(document).ready(function() {
								$("#registerForm").show();
								$("#loginForm").hide();
							});
					</script>';
		} else {
			echo '<script>
							$(document).ready(function() {
								$("#registerForm").hide();
								$("#loginForm").show();
							});
					</script>';
		}
		?>

		<div id="background">

			<div id=loginContainer>

				<div id="inputContainer">
					<form id="loginForm" action="register.php" method="POST">
						<h2>Login to your account</h2>
						<p>
							<?php echo $account->getError(Constants::$loginFailed);?>
							<label for="loginUsername">Username</label>
							<input id="loginUsername" type="text" name="loginUsername" placeholder="Username" value="<?php getInputValue('loginUsername')?>">
						</p>

						<p>
							<label for="loginPassword">Password</label>
							<input id="loginPassword" type="password" name="loginPassword" placeholder="Password" value="<?php getInputValue('loginPassword') ?>">
						</p>

						<button type="submit" name="loginButton">LOG IN</button>

						<div class="hasAccountText">
							<span id="hideLogin">Don't have an account yet? Signup here.</span>
						</div>

					</form>

					<form id="registerForm" action="register.php" method="POST">
						<h2>Create account</h2>
						<p>
							<?php echo $account->getError(Constants::$usernameCharacters);?>
							<?php echo $account->getError(Constants::$usernameTaken);?>
							<label for="username">Username</label>
							<input id="username" type="text" name="username" placeholder="e.g. razvanMiu" value="<?php getInputValue('username') ?>">
						</p>

						<p>
							<?php echo $account->getError(Constants::$firstNameCharacters);?>
							<label for="firstName">First Name</label>
							<input id="firstName" type="text" name="firstName" placeholder="e.g. Razvan" value="<?php getInputValue('firstName') ?>">
						</p>

						<p>
							<?php echo $account->getError(Constants::$lastNameCharacters);?>
							<label for="lastName">Last Name</label>
							<input id="lastName" type="text" name="lastName" placeholder="e.g. Miu" value="<?php getInputValue('lastName') ?>">
						</p>

						<p>
							<?php echo $account->getError(Constants::$emailsDoNotMatch);?>
							<?php echo $account->getError(Constants::$emailInvalid);?>
							<?php echo $account->getError(Constants::$emailTaken);?>
							<label for="email">Email</label>
							<input id="email" type="email" name="email" placeholder="e.g. razvan.miu@yahoo.com" value="<?php getInputValue('email') ?>">
						</p>

						<p>
							<label for="email2">Confirm email</label>
							<input id="email2" type="email" name="email2" placeholder="e.g. razvan.miu@yahoo.com" value="<?php getInputValue('email2') ?>">
						</p>

						<p>
							<?php echo $account->getError(Constants::$passwordsDoNotMatch);?>
							<?php echo $account->getError(Constants::$passwordNotAlphanumeric);?>
							<?php echo $account->getError(Constants::$passwordCharacters);?>
							<label for="password">Password</label>
							<input id="password" type="password" name="password" placeholder="e.g. 12345">
						</p>

						<p>
							<label for="password2">Confirm password</label>
							<input id="password2" type="password" name="password2" placeholder="e.g. 12345">
						</p>

						<p>
							<label for="adress">Adress</label>
							<input id="adress" type="text" name="adress" placeholder="e.g. Str. Elena Cuza">
						</p>

						<button type="submit" name="registerButton">SIGN UP</button>

						<div class="hasAccountText">
							<span id="hideRegister">Already have an account? Log in here.</span>
						</div>

					</form>

				</div>

				<div id="loginText">
					<h1>Get great devices, right now</h1>
					<h2>Best e-commerce web site</h2>
					<ul>
						<li>Buy latest technology pieces from us</li>
						<li>Lots of giveaways</li>
						<li>Incomming...</li>
					</ul>
				</div>

			</div>
		</div>

	</body>

	</html>
