<?php include('login_method.php') ?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Login</title>
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
	<div id="container">
		<div class="left-login"></div>

		<div class="right-login">
				<a href="../homePage/home.php" class="home">
					<i class="far fa-arrow-alt-circle-left fa-2x"></i>
					Back to Home
				</a>
			<div id="login-form">
				<br><p><strong>Login</strong></p>
				<form method="post" action="login.php">
					<?php echo display_error(); 
						unset($errors);
					?>

					<input type="email" class="form-control" name="email-cred" placeholder="Email Address"required><br>
					<input type="password" class="form-control" name="password-cred" placeholder="Password"required><br>
					<button type="submit" name="login-button" class="btn btn-success">LOGIN</button>
				</form>.

				<hr class="rounded-border"><br>
				<p>Don't have an account?</p>
				<form method="post" action="registrationPage/">
					<button type="submit" name="submit-button" class="btn btn-warning">CREATE A NEW ACCOUNT</button>
				</form>
			</div>
		</div>

	</div>
</body>
</html>