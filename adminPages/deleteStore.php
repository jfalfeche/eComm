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

		    /* check if the store status */
		    $status = "SELECT storeStatus FROM sellers WHERE sellerID = ?";
			$status = $conn->prepare($status);
		    $status->bind_param('s', $sellerID);

		    if ($status->execute() === TRUE)
		  	{
		    	$result = $status->get_result();
		    	$row = $result->fetch_assoc();

		    	/* if the store/seller being deleted is a store application */
		    	if($row['storeStatus'] == 0 )
		    	{
		    		$sql = "DELETE FROM sellers WHERE sellerID = ?";
				    $sql = $conn->prepare($sql);
				    $sql->bind_param('s', $sellerID);

				    if ($sql->execute() === TRUE)
				  	{
						success();
				  	}	
				  	else
				  	{
				  		error();
				  	}
		    	}

		    	/* if the store/seller is an existing store/seller */
		    	else
		    	{
		    		// update seller status to -1
			    	$sql = "UPDATE `sellers` SET storeStatus='-1' WHERE sellerID = ?";
				    $sql = $conn->prepare($sql);
				    $sql->bind_param('s', $sellerID);
				    
				    // update seller products to -1
				    $update_products = "UPDATE `product` SET stock ='-1' WHERE seller = ?";
				    $update_products = $conn->prepare($update_products);
				    $update_products->bind_param('s', $sellerID);

				  	if ($sql->execute() === TRUE)
				  	{
				    	$result = $sql->get_result();

				    	if($update_products->execute() == TRUE)
				    	{
				    		$result = $sql->get_result();
							success();
				    	}
				  	}	
				  	else
				  	{
				  		error();
				  	}
					
		    	}
			}

		    

		  	$conn->close();
		}

		else
		{
			Header("Location: admin_main.php");
		}
	}
	else
		Header("Location: ../loginPage/login.php");
?>

<?php

	function success()
	{
		echo '<script>
					alert("Success: Store application deleted.");
					window.location.href="admin_main.php";
			</script>';
	}

	function error()
	{
		//echo die ('Error updating database<br />' . mysqli_errno($conn) . ": " . mysqli_error($conn));
		echo '<script>
				alert("Error: Store application was not deleted.");
				window.location.href="admin_main.php";
		</script>';
	}	
?>