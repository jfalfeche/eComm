<?php

	if(isset($_POST['submit-button']))
	{
		update_seller();
	}

	else if(!isset($_GET['sellerID']))
	{
		header("Location: admin_main.php"); // Change to store main later on
	}

	if(isset($_POST['back-btn']))
	{
		back();
	}


	function back()
	{
		header("Location: ".$_SESSION['prevUrl']);
    }
    
	function update_seller()
	{
		global $conn, $sellerID, $storeStatus;

        $productName = $_POST['productName'];
        $image = base64_encode(file_get_contents(addslashes($_FILES['productPhoto']['tmp_name'])));
		$productDesc = $_POST['productDesc'];
        $productPrice = $_POST['productPrice'];
        $productUnit = $_POST['productUnit'];
        $quantity = $_POST['quantity'];

		if(empty($_FILES['profilePhoto']['tmp_name']))
		{
			if($storeStatus)
				$sql = "INSERT INTO product (productName,description,image,stock,price,productUnitID,productCategory) VALUES ($productName, $image, $productDesc, $productPrice, $productUnit, $quantity) WHERE `sellerID` = '$sellerID'";
		}

		if ($conn->query($sql))
		{
			unset($_POST['submit-button']);
			echo "<script>window.alert(\"Success: Product Added!\");</script>";
			header("Refresh:0");
		}
		else
		{	
			unset($_POST['submit-button']);
			echo "<script>window.alert(\"Error: Store Update Failed! Cannot upload the photo. \");</script>";
			//echo die ('Error updating database<br />' . mysqli_errno($conn) . ": " . mysqli_error($conn));
			header("Refresh:0");
		}
	}

?>