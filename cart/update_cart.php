<?php
    include_once '../homePage/database.php';

    if(!isset($_SESSION)) {
        session_start();
   }

    if(isset($_SESSION['userID'])){
        if(isset($_POST['submit-button']) || isset($_GET['update']))
            add_to_cart();		    
    } else {
        if(isset($_POST['submit-button'])) {
            echo "<script>window.alert(\"Login to add to cart.\");</script>";
            header("Location: ../loginPage/login.php");
        }
    }
    
    function getSellerID($productID){
        global $conn;

        $sql = "SELECT * from product WHERE product.productID = $productID";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $id = intval($row['seller']);
        return $id;
    }

    function add_to_cart(){
        global $conn;

        $productID = $_GET['action'];
        $quantity = $_POST['quantity'];
        if(!isset($quantity)) // for update
            $quantity = $_GET['quantity'];
        $buyerID = $_SESSION['userID'];
        $sellerID = getSellerID($productID);

        // get old quantity value
        $sql = "SELECT * from productdetail WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $o_quantity = $row['quantity'];

        updateStock($quantity, $productID, $sellerID, $o_quantity);
        updateQuantity($productID, $buyerID, $quantity);

		unset($_POST['submit-button']);
		
		header("Refresh:0");
    }

    function updateQuantity($productID, $buyerID, $quantity) {
        global $conn;

        $sql = "SELECT * from productdetail WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        
        //update product detail item
        $sql = "UPDATE productdetail SET quantity=? WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quantity);
        $stmt->execute();
        $stmt->close();
    }

    function updateStock($quantity, $productID, $sellerID, $o_quantity) {
        global $conn;

        // compute new stock
        $sql = "SELECT * from product WHERE product.productID = $productID";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        
        if($quantity > $row['quantity'])
            $stock = $row['stock'] - ($quantity - $o_quantity);
        else
            $stock = $row['stock'] + ($o_quantity - $quantity);
        //update stock
        $sql = "UPDATE product SET stock=? WHERE product.productID = $productID";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $stock);
        $stmt->execute();
		$stmt->close();
    }
?>