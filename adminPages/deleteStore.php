<?php
	if(isset($_GET['sellerID']))
	{
		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "philcafe";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

	    //get sellerID
	    $sellerID =  $_GET['sellerID'];

	    $sql = "DELETE FROM sellers WHERE sellerID = '$sellerID'";
	    $result = $conn->query($sql);
	    
	  	if ($conn->query($sql) === TRUE)
	  	{
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
?>