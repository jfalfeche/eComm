<?php
    include_once '../homePage/database.php';

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION['userID'])){
        delFromCart();
    } else {
        if(isset($_POST['submit-button'])) {
            echo "<script>window.alert(\"Login to modify cart.\");</script>";
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

    function getQuantity($productID, $buyerID){
        global $conn;

        $sql = "SELECT * from productdetail WHERE (productID = $productID AND buyerID = $buyerID)  AND inOrder = 0";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $quantity = intval($row['quantity']);
        return $quantity;
    }

    function success()
	{
		echo '<script>
					alert("Success: Product removed from cart.");
					window.location.href="cart.php";
			</script>';
	}

	function error()
	{
		echo '<script>
				alert("Error: Product was not removed from cart.");
				window.location.href="cart.php";
		</script>';
	}

    function delFromCart() {
        global $conn;

        $productID = $_GET['productID'];
        $buyerID = $_SESSION['userID'];
        $quantity = getQuantity($productID, $buyerID);
        $sellerID = getSellerID($productID);
  
        // get current stock in product
        $sql = "SELECT * from product WHERE product.productID = $productID";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $stock = $row['stock'];

        // compute new stock
        $n_stock = $stock + $quantity;

        // update stock in product
        $sql = "UPDATE product SET stock=? WHERE product.productID = $productID";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $n_stock);
        $stmt->execute();
        $stmt->close();
        
        // delete from productdetail
        $sql = "DELETE from productdetail WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $sql = $conn->prepare($sql);
        if ($sql->execute() === TRUE) {
            $result = $sql->get_result();
            success();
        } else {
            error();
        }
    }
?>