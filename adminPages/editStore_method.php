<?php

	if(isset($_POST['submit-button']))
	{
		update_seller();
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
				$sql = "UPDATE `sellers` SET storeName = '$storeName', storeEmail = '$storeEmail', storeDescription = 'storeDescription', storeStatus = true WHERE `sellerID` = '$sellerID'";
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
			header("Location: editStore.php?sellerID=$sellerID&success");	
		else
			 die ('Error updating database<br />' . mysqli_errno($conn) . ": " . mysqli_error($conn));
			//header("Location: editStore.php?sellerID=$sellerID&fail");
	}
?>