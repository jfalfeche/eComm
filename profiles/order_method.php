<?php
	
	if(isset($_POST['back-btn']))
	{
		back();
		unset($_POST['back-btn']);
	}

	function get_order()
	{

		if(isset($_POST['sortOrder']))
		{

			global $order, $buyerID;
			$sort = $_POST['sortOrder']; 
			if ($sort == "all")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status>0 AND order.status<5 ORDER BY order.dateOrdered ASC";
			else if($sort == "oldest-newest")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status>0 AND order.status<5 ORDER BY order.dateOrdered ASC";
			else if($sort == "newest-oldest")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status>0 AND order.status<5  ORDER BY order.dateOrdered DESC";
			else if($sort == "pending")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status=1 ORDER BY order.dateOrdered ASC";
			else if($sort == "approved")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status=2  ORDER BY order.dateOrdered ASC";
			else if($sort == "packed")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND  order.status=3  ORDER BY order.dateOrdered ASC";
			else if($sort == "shipped")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND  order.status=4  ORDER BY order.dateOrdered ASC";

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


	function get_product_details($orderNo)
	{
		global $conn, $buyerID;

		$sql = "SELECT productDetail.productID, productDetail.quantity, product.productName FROM `productDetail` INNER JOIN `product` ON productDetail.productID=product.productID WHERE productDetail.orderNo='$orderNo' AND productDetail.buyerID = '$buyerID'";
		$result = $conn->query($sql);

		$product_list = "";

		if(mysqli_num_rows($result) > 0)
		{
    		while ($row = $result->fetch_assoc())
    		{
    			$product_list = $product_list.$row['quantity']." x ".$row['productName']."    ";
    		}
		}

		echo substr(strtoupper($product_list), 0, 50);
	}


	function get_order_history()
	{
		if(isset($_POST['sortOrder']))
		{

			global $order, $buyerID;
			$sort = $_POST['sortOrder']; 
			if ($sort == "all")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' ORDER BY order.dateOrdered DESC";
			else if($sort == "oldest-newest")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' ORDER BY order.dateOrdered ASC";
			else if($sort == "newest-oldest")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID'   ORDER BY order.dateOrdered DESC";
			else if($sort == "pending")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status=1 ORDER BY order.dateOrdered ASC";
			else if($sort == "approved")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND order.status=2  ORDER BY order.dateOrdered ASC";
			else if($sort == "packed")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND  order.status=3  ORDER BY order.dateOrdered ASC";
			else if($sort == "shipped")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND  order.status=4  ORDER BY order.dateOrdered ASC";
			else if($sort == "completed")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND  order.status=5  ORDER BY order.dateOrdered ASC";
			else if($sort == "cancelled")
				$order = "SELECT * FROM `order` INNER JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE order.buyerID = '$buyerID' AND  order.status=6  ORDER BY order.dateOrdered ASC";
		}
	}
?>