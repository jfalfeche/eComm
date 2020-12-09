<?php
if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['LGUID']))
    {
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
	}
	else
        header("Location: ../loginPage/login.php");

?>

<?php
	function back()
	{
		session_start();
		header("Location: ".$_SESSION['prevUrl']);
	}

	function update_seller()
	{
		global $conn, $sellerID, $storeStatus;

		$storeName = filter_var($_POST['storeName'], FILTER_SANITIZE_STRING);
		$storeEmail = filter_var($_POST['storeEmail'], FILTER_SANITIZE_EMAIL);
		$storeDescription = filter_var($_POST['storeDescription'], FILTER_SANITIZE_STRING);

		if(empty($_FILES['profilePhoto']['tmp_name']))
		{
			if($storeStatus)
				//$sql = "UPDATE `sellers` SET storeName = '$storeName', storeEmail = '$storeEmail', storeDescription = 'storeDescription' WHERE `sellerID` = '$sellerID'";
				$sql = "UPDATE `sellers` SET storeName = ?, storeEmail = ?, storeDescription = ? WHERE `sellerID` = ?";

			else
				$sql = "UPDATE `sellers` SET storeName = ?, storeEmail = ?, storeDescription = ?, storeStatus = true WHERE `sellerID` = ?";
		}

		else	
		{
			$image = base64_encode(file_get_contents(addslashes($_FILES['profilePhoto']['tmp_name'])));

			if($storeStatus)
				$sql = "UPDATE `sellers` SET storeName = ?', storeEmail = ?, storeDescription = ?, profilePhoto = '$image' WHERE `sellerID` = ?'";
				else
					$sql = "UPDATE `sellers` SET storeName = ?, storeEmail = ?, storeDescription = ?, storeStatus = true, profilePhoto = '$image' WHERE `sellerID` = ?";
	
		}

		$sql = $conn->prepare($sql);

	    $sql->bind_param('ssss', $storeName, $storeEmail, $storeDescription, $sellerID);

		if ($sql->execute())
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