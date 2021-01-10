<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['LGUID']))
    {
    	//get order number
    	$orderNo =  filter_var($_GET['orderNo'], FILTER_SANITIZE_NUMBER_INT);

    	$shippingFee = $_POST['shippingFee'];
    	$status = $_POST['status'];

    }

    else
        header("Location: ../loginPage/login.php");
?>