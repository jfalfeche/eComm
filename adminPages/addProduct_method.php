<?php

	if(isset($_POST['submit-button']))
	{
		add_product();
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
    
	function add_product()
	{
		global $conn;

		//get sellerID
		$sellerID =  $_GET['sellerID'];
        $productName = $_POST['productName'];
        $image = base64_encode(file_get_contents(addslashes($_FILES['productPhoto']['tmp_name'])));
		$productDesc = $_POST['productDesc'];
        $productPrice = $_POST['productPrice'];
		$productUnit = $_POST['productUnit'];
		$productCategory = $_POST['productCategory'];
        $stock = $_POST['quantity'];

		$sql = "INSERT INTO product (productName, description, image, stock, price, productUnitID, productCategory, seller) VALUES ($productName, $productDesc, $image, $stock, $productPrice, $productUnit, $productCategory, $sellerID)";

		if (mysqli_query($conn,$sql))
		{
			unset($_POST['submit-button']);
			echo "<script>window.alert(\"Success: Product Added!\");</script>";
			header("Refresh:0");
		}
		else
		{	
			unset($_POST['submit-button']);
			echo "<script>window.alert(\"Error: Couldn't add product! Cannot upload the photo. \");</script>";
			//echo die ('Error updating database<br />' . mysqli_errno($conn) . ": " . mysqli_error($conn));
			header("Refresh:0");
		}
	}

?>