<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['LGUID']))
    {
		if(isset($_POST['submit-button']))
		{
			update_product();
		}
    }
    else
        header("Location: ../loginPage/login.php");
?>

<?php
	function update_product()
	{
		global $conn;

		//get sellerID
		$productID =  $_GET['productID'];
        $productName = $_POST['productName'];
		$productDesc = $_POST['productDesc'];
        $productPrice = $_POST['productPrice'];
		$productUnit = $_POST['productUnit'];
		$productCategory = $_POST['productCategory'];
        $stock = $_POST['quantity'];

        if(empty($_FILES['productPhoto']['tmp_name'])){
            $sql = "UPDATE product SET productName=?, description=?, stock=?, price=?, productUnitID=?, productCategory=? WHERE product.productID = $productID";
            $stmt = $conn->prepare($sql);
		    $stmt->bind_param("ssidii", $productName, $productDesc, $stock, $productPrice, $productUnit, $productCategory);
        } else {
            $image = base64_encode(file_get_contents(addslashes($_FILES['productPhoto']['tmp_name'])));
            $sql = "UPDATE product SET productName=?, description=?, image=?, stock=?, price=?, productUnitID=?, productCategory=? WHERE product.productID = $productID";
            $stmt = $conn->prepare($sql);
		    $stmt->bind_param("sssidii", $productName, $productDesc, $image, $stock, $productPrice, $productUnit, $productCategory);
        }

		$stmt->execute();
		$stmt->close();

		unset($_POST['submit-button']);
        echo "<script>window.alert(\"Success: Product Updated!\");</script>";
		header("Refresh:0");
	}
?>