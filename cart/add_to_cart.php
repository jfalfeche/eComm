<?php
    if(isset($_SESSION['userID'])){
        if(isset($_POST['submit-button']))
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
        $buyerID = $_SESSION['userID'];
        $sellerID = getSellerID($productID);

        // search table for existing product from buyer cart (if product is in an order, skip)
        $count = "SELECT COUNT(*) from productdetail WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $result = mysqli_query($conn,$count);
        $total_rows = mysqli_fetch_array($result)[0];
        // if product is existing on buyer's cart, update quantity
        if ($total_rows == 1) {
            updateQuantity($productID, $buyerID, $quantity);
        } else {
            addProduct($productID, $buyerID, $quantity, $sellerID);
        }
        
        updateStock($quantity, $productID, $sellerID);

		unset($_POST['submit-button']);
		echo "<script>window.alert(\"Success: Product Added to Cart!\");</script>";
		header("Refresh:0");
    }

    function updateQuantity($productID, $buyerID, $quantity) {
        global $conn;

        $sql = "SELECT * from productdetail WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $n_quantity = $row['quantity'] + $quantity;
        
        //update product detail item
        $sql = "UPDATE productdetail SET quantity=? WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $n_quantity);
        $stmt->execute();
        $stmt->close();
    }

    function addProduct($productID, $buyerID, $quantity, $sellerID) {
        global $conn;

        // add productdetail item
        $sql = "INSERT INTO productdetail (productID, quantity, buyerID, sellerID) VALUES (?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("iiii", $productID, $quantity, $buyerID, $sellerID);
		$stmt->execute();
        $stmt->close();
    }

    function updateStock($quantity, $productID, $sellerID) {
        global $conn;

        // compute new stock
        $sql = "SELECT * from product WHERE product.productID = $productID";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $stock = $row['stock'] - $quantity;
        //update stock
        $sql = "UPDATE product SET stock=? WHERE product.productID = $productID";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $stock);
        $stmt->execute();
		$stmt->close();
    }
?>