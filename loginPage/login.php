<?php include('login_method.php'); 
	//remove this later
	unset($_SESSION['user_type']);
?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Login</title>
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/login-style.css">
</head>
<body>
	<div id="container">
		<div class="left-login">
			<img src="../assets/img/login-bg.jpg">
		</div>

		<div class="right-login">
			<div class="return">
				<a href="../homePage/home.php" class="home" >
					<i class="far fa-arrow-alt-circle-left fa-lg"></i>&nbsp;
					<span style="font-size: 18px;">Back to Home</span>
				</a>
			</div>

			<div id="login-form">
				<form method="post" action="login.php">
					<span style="font-size: 24px;"><strong>Login</strong></span><br>
					<span style="color: red;"><small><?php echo display_error(); 
						unset($errors);
					?></small></span>
					<br>
					<input type="email" class="form-control" name="email-cred" placeholder="Email Address"required><br>
					<input type="password" class="form-control" name="password-cred" placeholder="Password"required><br>
					<button type="submit" name="login-button" class="btn btn-success pull-right">LOGIN</button>
				</form>

				<hr class="rounded-border">
				<p>Don't have an account?</p>
				<form method="post" action="registrationPage/" class="reg-button">
					<button type="submit" name="submit-button" class="btn btn-warning">CREATE A NEW ACCOUNT</button>
				</form>
			</div>
		</div>

	</div>
</body>
</html>