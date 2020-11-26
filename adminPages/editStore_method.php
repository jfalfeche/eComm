<?php

	if(isset($_POST['back-btn']))
	{
		back();
		unset($_POST['back-btn']);
	}

	if(isset($_POST['submit-button']))
	{
		update_seller();
	}

	else if(!isset($_GET['sellerID']))
	{
		header("Location: admin_main.php");
	}

	function back()
	{
		session_start();
		header("Location: ".$_SESSION['prevUrl']);
	}

	function update_seller()
	{
		global $conn, $sellerID, $storeStatus;

		$storeName = $_POST['storeName'];
		$storeEmail = $_POST['storeEmail'];
		$storeDescription = $_POST['storeDescription'];

		if(empty($_FILES['profilePhoto']['tmp_name']))
		{
			if($storeStatus)
				$sql = "UPDATE `sellers` SET storeName = '$storeName', storeEmail = '$storeEmail', storeDescription = 'storeDescription' WHERE `sellerID` = '$sellerID'";
			else
				$sql = "UPDATE `sellers` SET storeName = '$storeName', storeEmail = '$storeEmail', storeDescription = '$storeDescription', storeStatus = true WHERE `sellerID` = '$sellerID'";
		}

		else	
		{
			$image = base64_encode(file_get_contents(addslashes($_FILES['profilePhoto']['tmp_name'])));

			if($storeStatus)
				$sql = "UPDATE `sellers` SET storeName = '$storeName', storeEmail = '$storeEmail', storeDescription = 'storeDescription', profilePhoto = '$image' WHERE `sellerID` = '$sellerID'";
				else
					$sql = "UPDATE `sellers` SET storeName = '$storeName', storeEmail = '$storeEmail', storeDescription = 'storeDescription', storeStatus = true, profilePhoto = '$image' WHERE `sellerID` = '$sellerID'";
	
		}

		if ($conn->query($sql))
		{
			echo "<script>window.alert(\"Success: Store Update!\");</script>";
			unset($_POST['submit-button']);
			header("Refresh:0");
		}
		else
		{	
			echo "<script>window.alert(\"Error: Store Update Failed! Cannot upload the photo. \");</script>";
			unset($_POST['submit-button']);
			//echo die ('Error updating database<br />' . mysqli_errno($conn) . ": " . mysqli_error($conn));
			header("Refresh:0");
		}
	}

?>