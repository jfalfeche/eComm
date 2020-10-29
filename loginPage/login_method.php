<?php
	
	session_start();

	//connect to database
	$db = mysqli_connect('localhost', 'root', '', 'philcafe');

	//user credentials
	$email="";
	$userID="";
	$errors = array();

	if(isset($_POST['login-button']) && !isLoggedIn())
	{
		$email = filter_var($_POST['email-cred'], FILTER_SANITIZE_EMAIL);
		$password = $_POST['password-cred'];

		if(empty($email))
		{
			array_push($errors, "Input Email");
		}

		if(empty($password))
		{
			array_push($errors, "Input Password");
		}

		if(count($errors) == 0)
		{
			//hash password
			/*				*/
			
			$query = "SELECT * FROM LGU WHERE LGUemail = '$email' AND LGUpassword = '$password' LIMIT 1";
			$results = mysqli_query($db, $query);

			// user is admin
			if(mysqli_num_rows($results) == 1)
			{
				$_SESSION['user_type'] = 'admin';
				header('Location: ../admin.php');
			}

			//search in customers table
			else
			{
				$query = "SELECT * FROM customers WHERE customerEmail = '$email' AND password = '$password' LIMIT 1";
				$results = mysqli_query($db, $query);

				if(mysqli_num_rows($results) == 1)
				{
					$_SESSION['user_type'] = 'customer';
					echo $_SESSION['user_type'];
					header('Location: ../customer.php');
				}

				//else, user does not exist
				else
				{
					array_push($errors, "Email and password combination does not match.");
				}
			}
		}
	}

	function display_error()
	{
		global $errors;

		if (count($errors) > 0){
			echo '<div class="error">';
				foreach ($errors as $error){
					echo $error .'<br>';
				}
			echo '</div>';
		}
	}

	function isLoggedIn()
	{
		if (isset($_SESSION['user'])) {
			return true;
		}else{
			return false;
		}
	}
?>