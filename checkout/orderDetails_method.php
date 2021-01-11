<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['userID']) && (isset($_GET['orderNo']) && is_numeric($_GET['orderNo']))) {

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "philcafe";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            //get buyerID
            $buyerID = $userID = $_SESSION['userID'];
            $orderNo =  filter_var($_GET['orderNo'], FILTER_SANITIZE_NUMBER_INT);

            $info = "SELECT * FROM `customers` WHERE userID=$userID LIMIT 1";
            $info2 = "SELECT shippingAddress, paymentMethod, message FROM `order` WHERE orderNo = '$orderNo' AND buyerID= '$buyerID'";
            $items = "SELECT productdetail.quantity, product.productName, product.price, product.productID, product.stock, sellers.storeName FROM `productDetail` 
			INNER JOIN `product` ON productdetail.productID = product.productID 
			INNER JOIN `sellers` ON product.seller = sellers.sellerID
            WHERE orderNo  = '$orderNo' AND buyerID = '$buyerID'";
            $total = "SELECT orderNo, shippingFee, totalAmount, status FROM `order` WHERE orderNo = '$orderNo'";

        if (isset($_POST['cancel'])) {
                global $conn;

                $sql = "SELECT status FROM `order` WHERE orderNo = '$orderNo'";
                $result = $conn->query($sql);

                if (mysqli_num_rows($result) == 1) {
                    $row = $result->fetch_assoc();

                    $status = 6;
                    $updateSQL = "UPDATE `order` SET status=? WHERE order.orderNo=$orderNo";
                    $stmt = $conn->prepare($updateSQL);
                    $stmt->bind_param('i', $status);
                    $stmt->execute();
                    $stmt->close();

                    unset($_POST['cancel']);
                }
                
                $result = $conn->query($items);
                

                if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $stock = $row['stock'] + $row['quantity'];
                        $productID =  $row['productID'];

                        $updateSQL = "UPDATE `product` SET stock=? WHERE product.productID=$productID";
                        $stmt = $conn->prepare($updateSQL);
                        $stmt->bind_param('i', $stock);
                        $stmt->execute();
                        $stmt->close();

                        unset($_POST['cancel']);
                        header("Refresh:0");
                    }   $stock = 0;
                }
        }
    } else
        header("Location: ../loginPage/login.php"); 
?>

<?php
    function get_item_total($price, $quantity) {
        return $price * $quantity;
    }

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