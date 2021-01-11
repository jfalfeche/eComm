<?php
    include_once '../homePage/database.php';

    if(!isset($_SESSION)) {
        session_start();
    }

    if(isset($_SESSION['userID'])){
        if(isset($_GET['check']))
            checkStock();
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

    function checkStock(){
        global $conn;

        $productID = $_GET['action'];
        $quantity = $_GET['quantity'];
        $buyerID = $_SESSION['userID'];
        $sellerID = getSellerID($productID);

        // get old quantity value
        $sql = "SELECT * from productdetail WHERE (productID = $productID AND buyerID = $buyerID) AND inOrder = 0";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);
        $o_quantity = $row['quantity'];
        
        // compute new stock
        $sql = "SELECT * from product WHERE product.productID = $productID";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result);

        $stock = $row['stock'];
        echo "<script>checker = ".$stock.";</script>";
    }
?>