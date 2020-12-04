<?php
	
	function get_item_total($price, $quantity)
	{
		return number_format($price * $quantity, 2);
	}

	function get_subtotal($total, $shippingfee)
	{
		return number_format($total - $shippingfee, 2);
	}
?>