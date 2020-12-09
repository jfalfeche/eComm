<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['LGUID']))
    {
		if(isset($_GET['sellerID']))
		{
			$servername = "localhost";
		    $username = "root";
		    $password = "";
		    $dbname = "philcafe";
		    // Create connection
		    $conn = new mysqli($servername, $username, $password, $dbname);

		    //get sellerID
		    $sellerID =  filter_var($_GET['sellerID'], FILTER_SANITIZE_NUMBER_INT);

		    $sql = "DELETE FROM sellers WHERE sellerID = ?";
		    $sql = $conn->prepare($sql);

		    $sql->bind_param('s', $sellerID);
		    
		  	if ($sql->execute() === TRUE)
		  	{
		    	$result = $sql->get_result();
				echo '<script>
						alert("Success: Store application deleted.");
						window.location.href="admin_main.php";
				</script>';
		  	}	
		  	else
		  	{
		  		echo die ('Error updating database<br />' . mysqli_errno($conn) . ": " . mysqli_error($conn));
				// echo '<script>
				// 		alert("Error: Store application was not deleted.");
				// 		window.location.href="admin_main.php";
				// </script>';
		  	}

		  	$conn->close();
		}

		else
		{
			Header("Location: admin_main.php");
		}
	}
	else
		header("Location: ../loginPage/login.php");
?>