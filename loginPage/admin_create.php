<!DOCTYPE html>
<html>
<head>
	<title>Create Admin Account</title>
</head>
<body>
	<a href="login.php"></a>
	<form method="post" action="admin_create.php">
		<input type="email" name="email-admin" required><br>
		<input type="password" name="password-admin" required><br>
		<button type="submit" name="create-button">CREATE</button>
	</form>
</body>
</html>

<?php
	session_start();
    $db = mysqli_connect('localhost', 'root', '', 'philcafe');

    if(isset($_POST['create-button']))
    {
    	$email = filter_var($_POST['email-admin'], FILTER_SANITIZE_EMAIL);
		$password = password_hash($_POST['password-admin'], PASSWORD_DEFAULT);
		create_admin_account($email, $password);
    }

	function create_admin_account($email, $hash_pwd)
	{
		global $db;
		$query = "SELECT * FROM LGU WHERE LGUemail = '$email' LIMIT 1";
		$results = mysqli_query($db, $query);

		if(mysqli_num_rows($results) == 1)
		{
			echo "user already exists!";
			unset($_POST['create-button']);
		}

		else
		{
			$insert_stmt = "INSERT INTO LGU (`LGUemail`, `LGUpassword`) VALUES ('$email', '$hash_pwd')";
			if(mysqli_query($db, $insert_stmt))
				echo "user created";
			else
				echo "error: user not created;";
		}

	}

	mysqli_close($db);
?>