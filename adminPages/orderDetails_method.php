<?php
	if (session_status() == PHP_SESSION_NONE) {
				session_start();
	}

	if(isset($_SESSION['LGUID'])&& (isset($_GET['orderNo']) && is_numeric($_GET['orderNo'])))
	{

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "philcafe";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		
	   	$page = $_SERVER["REQUEST_URI"];
		
		//save previous currentUrl as previousUrl
	   	if($page != $_SESSION['currentUrl'])
	   		$_SESSION['prevUrl'] = $_SESSION['currentUrl'];

		// save current url as currentUrl
		$_SESSION['currentUrl'] = $page;
		

		if(isset($_POST['back-btn']))
		{
			back();
			unset($_POST['back-btn']);
		}

		//get order number
		$orderNo =  filter_var($_GET['orderNo'], FILTER_SANITIZE_NUMBER_INT);

        $info = "SELECT order.orderNo, order.status, order.shippingAddress, order.paymentMethod, 
        		  order.message, order.shippingFee, order.totalAmount,
        		  customers.firstName, customers.middleName, customers.lastName,
        		  customers.contactNumber, customers.customerEmail
				  FROM `order` INNER JOIN `customers` 
				  ON order.buyerID = customers.userID
				  WHERE order.orderNo = '$orderNo'
				  LIMIT 1";

		$items = "SELECT productdetail.quantity, product.productName, product.price, sellers.storeName 
				  FROM `productDetail` 
				  INNER JOIN `product` ON productdetail.productID = product.productID 
				  INNER JOIN `sellers` ON product.seller = sellers.sellerID
				  WHERE orderNo  = '$orderNo'";
			
		if(isset($_POST['updateBtn']))
		{
			//get updated values
			$shippingFee = $_POST['shippingFee'];
			$status = $_POST['status'];

			unset($_POST['updateBtn']);
			unset($_POST['submit']);
 
			if($status == "pending")
					$update = "UPDATE `order` 
							   SET shippingFee=$shippingFee, status=1
							   WHERE orderNo = $orderNo";

			else if($status == "approved")
					$update = "UPDATE `order` 
							   SET shippingFee=$shippingFee, status=2
							   WHERE orderNo = $orderNo";
										 
			else if($status == "packed")
					$update = "UPDATE `order` 
							   SET shippingFee=$shippingFee, status=3
							   WHERE orderNo = $orderNo";

			else if($status == "shipped")
					$update = "UPDATE `order` 
							   SET shippingFee=$shippingFee, status=4
							   WHERE orderNo = $orderNo";

			else if($status == "completed")
					$update = "UPDATE `order` 
							   SET shippingFee=$shippingFee, status=5,dateCompleted=NOW()
							   WHERE orderNo = $orderNo";

			else if($status == "cancelled")
					$update = "UPDATE `order` 
							   SET shippingFee=$shippingFee, status=6
							   WHERE orderNo = $orderNo";

			if($conn->query($update))
			{
				echo "<script>window.alert(\"Success: Order Updated!\");</script>";
				header("Refresh:0");

			}
			else
			{
				echo "<script>window.alert(\"Error: Order NOT Updated!\");</script>";
				header("Refresh:0");
			}
		}

	}

	else
		header("Location: ../loginPage/login.php");
?>

<?php
	function back()
	{
		header("Location: ".$_SESSION['prevUrl']);
	}

	function get_item_total($price, $quantity) {
        return $price * $quantity;
    }

    function get_status_name($status_id) {
		global $conn;
		$sql = "SELECT name from `orderStatus` WHERE orderStatusID=$status_id LIMIT 1";
    	$result = $conn->query($sql);

    	if(mysqli_num_rows($result) == 1)
    	{
    		$row = $result->fetch_assoc();
    		echo strtoupper($row['name']);
    	}
    }

    function get_status_color($value){
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
?>