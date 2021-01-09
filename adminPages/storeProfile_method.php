
<?php
	function search_products($value)
	{
		global $products, $sellerID;
		$products = "SELECT * from `product`, `productUnit`
					 WHERE (productUnit.productUnitID = product.productUnitID) 
					 AND(product.seller=$sellerID)
					 AND ((product.productName LIKE '%{$value}%')
					 OR (product.description LIKE '%{$value}%'))";
	}
?>