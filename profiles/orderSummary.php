<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
	if(isset($_SESSION['userID']) && (isset($_GET['orderNo']) && is_numeric($_GET['orderNo'])))
	{
		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "philcafe";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

	    //get buyerID
	    $buyerID =  $_SESSION['userID'];

	    //get orderNo
	    $orderNo =  filter_var($_GET['orderNo'], FILTER_SANITIZE_NUMBER_INT);

	    $items = "SELECT productdetail.quantity, product.productName, product.price, sellers.storeName FROM `productDetail` 
			INNER JOIN `product` ON productdetail.productID = product.productID 
			INNER JOIN `sellers` ON product.seller = sellers.sellerID
			WHERE orderNo  = '$orderNo' AND buyerID = '$buyerID'";

	   $total = "SELECT shippingFee, totalAmount FROM `order` WHERE orderNo = '$orderNo'";
	    include 'orderSummary_method.php'

?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Order Summary</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="../navbar/nav.css">
	<link rel="stylesheet" href="../assets/css/order-style.css">
</head>
<body>

	<!--NAV-->
    <nav class="nav buyer">
        <div class="col-md-3">
            <div class="logo">
                <img class="imglogo" src="../assets/img/philcafe.png" alt="">
                <h1 class="logotitle">PhilCafe</h1>
            </div>
        </div>
        <div class="col-md-2"></div>
        <?php include '../navbar/buyer.php' ?>
    </nav>
    <!--END NAV-->

	<div id="container">
		<div id="title">
			<form method="post" action="orderSummary.php?orderNo=<?php echo $orderNo;?>" id="form-id" class="inline" >
				<button type="submit" name="back-btn" id="submit-id" class="inline">
					<i class="fas fa-arrow-circle-left fa-3x inline"></i>
				</button>
			</form>

			<span style="font-size: 2em; font-weight: 500;" class="inline">ORDER SUMMARY</span>
			<hr class="mt-1 mb-2">
		</div>

		<div id="main">
			<span style="font-size: 12px; font-weight: 500;"><i>click on any item to view details</i></span>
			<table id="order-summary-table" class="table table-hover">
				<thead>
					<tr>
					    <th scope="col">SOLD BY</th>
					    <th scope="col">PRODUCT</th>
					    <th scope="col"> <div style="text-align: right;">PRICE</div></th>
					    <th scope="col"> <div style="text-align: right;">QUANTITY</div></th>
					    <th scope="col"> <div style="text-align: right;">TOTAL</div></th>
				    </tr>
				</thead>
				<tbody>
					<?php
						$subtotal = 0;

						$result = $conn->query($items);
		                if ($result->num_rows > 0) 
		                {
		                	$prevOrderNo = null;
		                    // output data of each row
		                    while ($row = $result->fetch_assoc()) 
		                    {
	                ?>
	                        <tr>
	                            <td>
	                                <?php echo $row['storeName'] ?>
	                            </td>
	                            <td>
	                            	<?php echo $row['productName'] ?>
	                            </td>
	                            <td>
	                                <div style="text-align: right;">
	                                	<?php echo number_format($row['price'], 2, '.', ' '); ?>	
	                                </div>
	                            </td>
	                            <td>
	                                <div style="text-align: right;">
	                                	<?php echo $row['quantity'] ?>
	                                </div>
	                            </td>
	                            <td>
	                            	<div style="text-align: right;">
	                                	<?php echo number_format(get_item_total($row['price'], $row['quantity']), 2, '.', ' '); ?>
	                                </div>
	                            </td>
	                            <td style="display: none;">
	                            	<a href="orderDetails.php?orderNo=<?php echo $row['orderNo']?>" class="btn btn-primary"></a>
	                            </td>
	                        </tr>
	                       
		                <?php

		                	}
		                } 
		                	else echo "Database is empty";
		                	
		                ?>

		            <?php
		            	$result = $conn->query($total);

		            	if ($result->num_rows > 0) 
		                {
							$row = $result->fetch_assoc();
							$grandTotal = $row['totalAmount'] + $row['shippingFee'];
		            ?>
		            	<tr class="black-top-border">
		            		<td></td>
		            		<td></td>
		            		<td></td>
		            		<td>Subtotal</td>
		            		<td >
		            			<div style="text-align: right;">
								<?php echo number_format($row['totalAmount'], 2, '.', ' ') ?>
		            			</div>
		            		</td>
		                </tr>

		                <tr>
		                	<td></td>
		            		<td></td>
		            		<td></td>
		            		<td>Shipping Fee</td>
		            		<td>
		            			<div style="text-align: right;">
		            				<?php echo number_format($row['shippingFee'], 2, '.', ' ') ?>
		            			</div>
		            		</td>
		                </tr>

		            	<tr class="black-top-border total">
		                	<td></td>
		            		<td></td>
		            		<td></td>
		            		<td style="font-size: 1.25em;"><b>TOTAL</b></td>
		            		<td>
		            			<div style="text-align: right; font-size: 1.25em;">
		            				<b>PHP&emsp;<?php echo number_format($grandTotal, 2, '.', ' ') ?></b>
		            			</div>
		            		</td>
		                </tr>
		            <?php
		                }
		            ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>

<?php
	}
	else
		header("Location: profile_buyer.php");

 ?>