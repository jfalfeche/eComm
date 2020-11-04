<?php
	
	function get_order()
	{
		if(isset($_POST['sort']))
		{

			global $order;
			$sort = $_POST['sort']; 
			if($sort == "oldest-newest")
				$order = "SELECT * from `order` WHERE status>22 AND status<27 ORDER BY dateOrdered ASC";
			else if($sort == "newest-oldest")
				$order = "SELECT * from `order` WHERE status>22 AND status<27 ORDER BY dateOrdered DESC";
			else if($sort == "pending")
				$order = "SELECT * from `order` WHERE status=23 ORDER BY dateOrdered ASC";
			else if($sort == "approved")
				$order = "SELECT * from `order` WHERE status=24  ORDER BY dateOrdered ASC";
			else if($sort == "packed")
				$order = "SELECT * from `order` WHERE status=25  ORDER BY dateOrdered ASC";
			else if($sort == "shipped")
				$order = "SELECT * from `order` WHERE status=26  ORDER BY dateOrdered ASC";
		}
	}
	function get_status_color($value)
	{
		if($value == "23")
			return "#FF0000";
		else if($value == "24")
			return "#00FFD9";
		else if($value == "25")
			return "#0057FF";
		else if($value == "26")
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

		$sql = "SELECT firstName, middleName, lastName from `customers` WHERE userID=$id LIMIT 1";
    	$result = $conn->query($sql);

    	if(mysqli_num_rows($result) == 1)
    	{
    		$row = $result->fetch_assoc();
    		$name = $row['firstName']." ".$row['middleName']." ".$row['lastName'];
    		echo strtoupper($name);
    	}
	}

	function get_product_details($id)
	{

	}
?>