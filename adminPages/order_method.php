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

	function get_order()
	{

		if(isset($_POST['sortOrder']))
		{

			global $order, $sellerID;
			$sort = $_POST['sortOrder']; 
			if ($sort == "all")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status>0 AND order.status<5 ORDER BY order.dateOrdered ASC, order.orderNo ASC";
			else if($sort == "oldest-newest")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status>0 AND order.status<5 ORDER BY order.dateOrdered ASC, order.orderNo ASC";
			else if($sort == "newest-oldest")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status>0 AND order.status<5  ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "pending")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status=1 ORDER BY order.dateOrdered ASC, order.orderNo ASC";
			else if($sort == "approved")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status=2  ORDER BY order.dateOrdered ASC, order.orderNo ASC";
			else if($sort == "packed")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND  order.status=3  ORDER BY order.dateOrdered ASC, order.orderNo ASC";
			else if($sort == "shipped")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND  order.status=4  ORDER BY order.dateOrdered ASC, order.orderNo ASC";

		}
	}

	function get_status_color($value)
	{
		if($value == "1")
			return "#FF0000";
		else if($value == "2")
			return "#00FFD9";
		else if($value == "3")
			return "#0057FF";
		else if($value == "4")
			return "#FFF500";
		else if($value == "5")
			return "#0A5900";
		else if($value == "6")
			return "#967E69";

	}

	function get_status_name($status_id)
	{
		global $conn;
		$sql = "SELECT name from `orderStatus` WHERE orderStatusID=$status_id LIMIT 1";
    	$result = $conn->query($sql);

    	if(mysqli_num_rows($result) == 1)
    	{
    		$row = $result->fetch_assoc();
    		echo strtoupper($row['name']);
    	}
	}

	function get_customer_name($id)
	{
		global $conn;

		$sql = "SELECT firstName, middleName, lastName FROM `customers` WHERE userID=$id LIMIT 1";
    	$result = $conn->query($sql);

    	if(mysqli_num_rows($result) == 1)
    	{
    		$row = $result->fetch_assoc();
    		$name = $row['firstName']." ".$row['middleName']." ".$row['lastName'];
    		echo strtoupper($name);
    	}
	}

	function get_product_details($id, $orderNo)
	{
		global $conn, $sellerID;

		$sql = "SELECT productDetail.productID, productDetail.quantity, product.productName FROM `productDetail` LEFT JOIN `product` ON productDetail.productID=product.productID WHERE productDetail.buyerID='$id' AND productDetail.orderNo='$orderNo' AND productDetail.sellerID = '$sellerID'";
		$result = $conn->query($sql);

		$product_list = "";

		if(mysqli_num_rows($result) > 0)
		{
    		while ($row = $result->fetch_assoc())
    		{
    			$product_list = $product_list.$row['quantity']." x ".$row['productName']."    ";
    		}
		}

		echo substr(strtoupper($product_list), 0, 25);
	}


	function get_order_history()
	{
		if(isset($_POST['sortOrder']))
		{

			global $order, $sellerID;
			$sort = $_POST['sortOrder']; 
			if ($sort == "all")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "oldest-newest")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' ORDER BY order.dateOrdered ASC, order.orderNo ASC";
			else if($sort == "newest-oldest")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID'   ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "pending")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status=1 ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "approved")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND order.status=2  ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "packed")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND  order.status=3  ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "shipped")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND  order.status=4  ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "completed")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND  order.status=5  ORDER BY order.dateOrdered DESC, order.orderNo DESC";
			else if($sort == "cancelled")
				$order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.sellerID = '$sellerID' AND  order.status=6  ORDER BY order.dateOrdered DESC, order.orderNo DESC";
		}
	}
?>