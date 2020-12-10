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
		    
		    //get productID
		    $productID =  filter_var($_GET['productID'], FILTER_SANITIZE_NUMBER_INT);
		    
		    $sql = "UPDATE product SET stock = '-1' WHERE `seller` = ? AND `productID` = ?";
		    $sql = $conn->prepare($sql);

		    $sql->bind_param('ss', $sellerID, $productID);
		    
		  	if ($sql->execute() === TRUE)
		  	{
		    	$result = $sql->get_result();
				echo '<script>
						alert("Success: Store product deleted.");
						window.location.href="storeProfile.php?sellerID='.$sellerID.'";
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