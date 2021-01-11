<?php
	if(!isset($_SESSION['LGUID']))
        Header("Location: ../loginPage/login.php");

    if(isset($_POST['back-btn']))
	{
		back();
		unset($_POST['back-btn']);
	}
?>

<?php
	function back()
	{
		header("Location: ".$_SESSION['currentUrl']);
	}

	function get_item_total($price, $quantity)
	{
		return number_format($price * $quantity, 2, '.', ' ');
	}

	function get_subtotal($total, $shippingfee)
	{
		return number_format($total - $shippingfee, 2, '.', ' ');
	}
?>