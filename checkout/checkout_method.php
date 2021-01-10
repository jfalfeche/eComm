<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['userID'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "philcafe";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        //get buyerID
        $buyerID = $userID = $_SESSION['userID'];

        $customer = "SELECT * FROM `customers` WHERE userID=$userID LIMIT 1";
        
        $items = "SELECT productDetail.productDetailID, productdetail.quantity, product.productName, product.price FROM `productDetail` 
                    INNER JOIN `product` ON productdetail.productID = product.productID WHERE productDetail.buyerID  = '$buyerID' AND productDetail.inOrder = '0'
                    ORDER BY productDetail.productDetailID ASC";

        function get_customer_name($userID){
            global $conn;

            $sql = "SELECT firstName, middleName, lastName FROM `customers` WHERE userID=$userID LIMIT 1";
            $result = $conn->query($sql);

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $name = $row['firstName'] . " " . $row['middleName'] . " " . $row['lastName'];
                echo ($name);
            }
        }

        if (isset($_POST['submit'])) {

            //get appropriate values
            $shippingAddress = $_POST['shippingAddress'];
            $paymentMethod = $_POST['paymentMethod'];
            $message = $_POST['message'];

            //check how many unique sellers from checked out items
            $unique_sellerID = "SELECT COUNT(DISTINCT sellerID) FROM `productdetail`
                                WHERE productdetail.inOrder = 0
                                AND  productdetail.buyerID = $buyerID";

            $result = $conn->query($unique_sellerID);

            function get_item_total($price, $quantity) {
                return $price * $quantity;
            }

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc(); 
                $index_stop = $row['COUNT(DISTINCT sellerID)'];
                
                //get the unique sellerIDs
                $sellerIDs = "SELECT DISTINCT sellerID FROM `productdetail` 
                            WHERE productdetail.inOrder = false
                            AND productdetail.buyerID = $buyerID";

                $result_sellerID = $conn->query($sellerIDs);

                //create an order for each unique seller  
                while($row_sellerID = $result_sellerID->fetch_assoc())
                {	
                    //current sellerID
                    $sellerID = (int)$row_sellerID['sellerID'];

                    // default shipping fee here is 0
                    $shippingFee = 0;
                    $totalAmount_perSeller = totalAmount_perSeller($buyerID, $sellerID, $shippingFee);
                    $orderStatusID = 1;
                    
                    $place_order = "INSERT INTO `order` 
                                    (`buyerID`, `shippingAddress`, `status`, `paymentMethod`, `dateOrdered`, `shippingFee`,`totalAmount`, `message`) 
                                    VALUES ($buyerID, '$shippingAddress', $orderStatusID, '$paymentMethod', NOW(), $shippingFee, $totalAmount_perSeller, '$message')";
                    
                    if($conn->query($place_order))
                    {
                        $orderID = $conn->insert_id;
                        
                        $update_productDetail = "UPDATE `productdetail` 
                                                SET inOrder = 1, orderNo = $orderID
                                                WHERE buyerID = $buyerID
                                                AND sellerID = $sellerID
                                                AND inOrder = 0";

                        if($conn->query($update_productDetail))
                        {
                            continue;
                        }
                        else
                        {
                            /*change here, redirect somewhere*/
                            echo "error placing order";
                        }

                    }
                    
                }
                //header("Location: pendingOrders.php");
            }

            else{
                /*change here, redirect somewhere*/
                echo "error: no product in cart";
            }
        } //echo '<script>alert("Order placed!")</script>'; 
          //echo '<script>window.location="../checkout/checkoutSummary.php"</script>';
    }
    else
        header("Location: ../loginPage/login.php");

?>

<?php
	function totalAmount_perSeller($buyerID, $sellerID, $shippingFee)
	{
		global $conn;
		$sql = "SELECT *
				FROM `productdetail` 
				INNER JOIN `product` ON productdetail.productID = product.productID
				WHERE productdetail.inOrder = false
				AND productdetail.sellerID = $sellerID
				AND productdetail.buyerID = $buyerID";

		$result = $conn->query($sql);

		$total = $shippingFee;

		while($row = $result->fetch_assoc())
		{
			$total = $total + ($row['quantity'] * $row['price']);
		}

		return (double)$total;
	}
?>