<?php


	if(isset($_POST['back-btn']))
	{
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	    	$current_url = "https://";
		else
		    $current_url = "http://";
		// Append the host(domain name, ip) to the URL.   
		$current_url .= $_SERVER['HTTP_HOST'];

		// Append the requested resource location to the URL   
		$current_url .= $_SERVER['REQUEST_URI'];
		
		unset($_POST['back-btn']);

		if(strpos($current_url, 'checkout')) 
			back_checkout();
		 
		else if(!isset($_GET['orderNo']))
			back_cart();
		
		else 
			back_orderDetails();
	}
?>

<?php

	function back_cart()
	{
		header("Location: ../cart/cart.php");
	}

	function back_checkout()
	{
		header("Location: ../checkout/checkout.php");
	}

	function back_orderDetails()
	{
		global $orderNo;
		header("Location: ../checkout/orderDetails.php?orderNo=".$orderNo);
	}

	function get_item_total($price, $quantity)
	{
		return $price * $quantity;
	}

	function get_subtotal($total, $shippingfee)
	{
		return $total - $shippingfee;
	}
?>