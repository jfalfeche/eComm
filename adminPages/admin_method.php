<?php
	
	function get_order()
	{
		if(isset($_POST['sortOrder']))
		{

			global $order;
			$sort = $_POST['sortOrder']; 
			if($sort == "all")
				$order = "SELECT * from `order` WHERE status>0 AND status<5 ORDER BY dateOrdered ASC";
			else if($sort == "oldest-newest")
				$order = "SELECT * from `order` WHERE status>0 AND status<5 ORDER BY dateOrdered ASC";
			else if($sort == "newest-oldest")
				$order = "SELECT * from `order` WHERE status>0 AND status<5 ORDER BY dateOrdered DESC";
			else if($sort == "pending")
				$order = "SELECT * from `order` WHERE status=1 ORDER BY dateOrdered ASC";
			else if($sort == "approved")
				$order = "SELECT * from `order` WHERE status=2  ORDER BY dateOrdered ASC";
			else if($sort == "packed")
				$order = "SELECT * from `order` WHERE status=3  ORDER BY dateOrdered ASC";
			else if($sort == "shipped")
				$order = "SELECT * from `order` WHERE status=4  ORDER BY dateOrdered ASC";
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
		global $conn;

		$sql = "SELECT productDetail.productID, productDetail.quantity, product.productName FROM `productDetail` INNER JOIN `product` ON productDetail.productID=product.productID WHERE productDetail.buyerID='$id' AND productDetail.orderNo='$orderNo'";
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


	function get_pending_store()
	{
		if(isset($_POST['sortPendingStore']))
		{

			global $store;

			$sort = $_POST['sortPendingStore']; 
			if($sort == "all")
					$store = "SELECT * from `sellers` WHERE storeStatus=false";
			else if($sort == "A-to-Z")
				$store = "SELECT * from `sellers` WHERE storeStatus=false ORDER BY storeName ASC";
			else if($sort == "Z-to-A")
				$store = "SELECT * from `sellers` WHERE storeStatus=false ORDER BY storeName DESC";
			else if($sort == "oldest-newest")
				$store = "SELECT * from `sellers` WHERE storeStatus=false ORDER BY dateCreated ASC";
			else if($sort == "newest-oldest")
				$store = "SELECT * from `sellers` WHERE storeStatus=false ORDER BY dateCreated DESC";
		}
	}

	function search_pending_store($value)
	{
		global $store;
		$store = "SELECT * from `sellers` WHERE (storeStatus=false AND storeName LIKE '%{$value}%')";
	}


	function get_store()
	{
		if(isset($_POST['sortStore']))
		{

			global $partner_stores, $offset, $no_of_records_per_page;

			$sort = $_POST['sortStore']; 
			if($sort == "A-to-Z")
				$partner_stores = "SELECT * FROM `sellers` WHERE storeStatus=true ORDER BY storeName ASC LIMIT $offset, $no_of_records_per_page ";
			else if($sort == "Z-to-A")
				$partner_stores = "SELECT * FROM `sellers` WHERE storeStatus=true ORDER BY storeName DESC LIMIT $offset, $no_of_records_per_page ";
			else if($sort == "oldest-newest")
				$partner_stores = "SELECT * FROM `sellers` WHERE storeStatus=true ORDER BY dateCreated ASC LIMIT $offset, $no_of_records_per_page ";
			else if($sort == "newest-oldest")
				$partner_stores = "SELECT * FROM `sellers` WHERE storeStatus=true ORDER BY dateCreated DESC LIMIT $offset, $no_of_records_per_page ";
		}
	}

	function search_partner_stores($value)
	{
		global $partner_stores, $offset, $no_of_records_per_page;

		$partner_stores = "SELECT * from `sellers` WHERE (storeStatus=true AND storeName LIKE '%{$value}%') LIMIT $offset, $no_of_records_per_page ";
	}
?>


