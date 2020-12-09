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
		login();
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
		if (isset($_SESSION['user_type'])) {
			return true;
		}else{
			return false;
		}
	}

	function login()
	{
		global $db, $errors;

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

		//hash password
		/*				*/

		if(count($errors) == 0)
		{
			

			$query = "SELECT LGUID, LGUpassword FROM LGU WHERE LGUemail = '$email' LIMIT 1";
			$results = mysqli_query($db, $query);

			
			
			// user is admin
			if(mysqli_num_rows($results) == 1)
			{
				$row = $results->fetch_assoc();
				if(password_verify($password, $row['LGUpassword']))
				{
					$_SESSION['LGUID'] = $row['LGUID'];
					header('Location: ../adminPages/admin_main.php');
				}

				//password is invalid
				else
				{
					array_push($errors, "Email and password combination does not match.");
				}
			}

			//search in customers table
			else
			{
				$query = "SELECT userID, password FROM customers WHERE customerEmail = '$email' LIMIT 1";
				$results = mysqli_query($db, $query);

				if(mysqli_num_rows($results) == 1)
				{
					$row = $results->fetch_assoc();
					if(password_verify($password, $row['password']))
					{
						$_SESSION['userID'] = $row['userID'];
						header('Location: ../profiles/profile_buyer.php');
					}	

					else
					{
						array_push($errors, "Email and password combination does not match.");
					}
				}

				//else, user does not exist
				else
				{
					array_push($errors, "Email and password combination does not match.");
				}
			}
		}
	}
?>