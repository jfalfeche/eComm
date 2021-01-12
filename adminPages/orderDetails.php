<?php include 'orderDetails_method.php' ?>
<!DOCTYPE html>
<html>

<head>
	<title>PhilCafe - Order Details</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>

    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../checkout/checkout.css">
</head>

<body>
	<!--NAV-->
    <nav class="nav guest">
        <div class="col-md-2">
            <div class="logo">
                <h1>LOGO</h1>
            </div>
        </div>
        <div class="col-md-8"></div>
        <?php 
            include '../navbar/admin.php';
        ?>
    </nav>
    <!--END NAV-->

    <div id="container">
    	<div class="column left">
	        <div class="header">
	        <form method="post" action="orderDetails.php?orderNo=<?php echo $orderNo?>" id="form-id" class="inline buttons">
				<button type="submit" name="back-btn" id="submit-id" class="inline buttons" style="border: none; outline:none; background: #F7F6F4;">
					<i class="fas fa-arrow-circle-left fa-3x inline"></i>
				</button>
			</form>
	            <h1 class="underline">SHIPPING INFORMATION</h1>
	        </div>

        	<table class="table table-bordered">

	        <?php
	            $result = $conn->query($info);
	            if (mysqli_num_rows($result) == 1) 
	            {
	                $row = $result->fetch_assoc();
	        ?>

	            <tbody>
	                <th scope="col" colspan="2">Personal Details</th>
	                <tr><td colspan="2"><?php echo ($row['firstName'].' '.$row['middleName'].' '.$row['lastName']); ?></td></tr>
	                <tr>
	                    <td><?php echo $row["contactNumber"] ?></td>
	                    <td><?php echo $row["customerEmail"] ?></td>
	                </tr>

	                <tr><th scope="col" colspan="2">Address Details</th></tr>
	                <tr><td colspan="2"><?php echo $row["shippingAddress"] ?></td></tr>
	                
	                <tr><th scope="col" colspan="2">Payment Method</th></tr>
	                <tr><td colspan="2"><?php echo $row["paymentMethod"] ?></td></tr>
	                
	                <tr><th scope="col" colspan="2">Message to Seller</th></tr>
	                <tr><td colspan="2"><?php echo $row["message"] ?></td> </tr>
	            </tbody>
		        
        	</table>
    	</div>

    	<div class="column right">
	        <div class="header"><h1 class="underline">ORDER SUMMARY</h1></div>
	        <table class="table table-borderless summary">
	        <tbody>
	            <tr>
	                <th style="line-height: 3px;">ORDER #</th>
	                <td></td><td></td>
	                <th style="line-height: 3px;"><?php echo sprintf('%08d', $row['orderNo']) ?></th>
	            </tr>
	            <tr>
	                <th style="line-height: 3px;">ORDER STATUS</th>
	                <td></td><td></td>
	                <td style="line-height: 3px;"><span style="color: <?php echo get_status_color($row['status']) ?>;">
		                    <strong><?php get_status_name($row['status']); ?></strong>
		                </span>
	                </td>
	            </tr>

	            <?php 
	                $result_items = $conn->query($items); 
	                if ($result_items->num_rows > 0) 
	                {
	                	$row_items = $result_items->fetch_assoc();
	            ?>

	            <tr>
	                <th style="line-height: 3px;">SELLER</th>
	                <td></td><td></td>
	                <td style="line-height: 3px;"><?php echo $row_items["storeName"] ?>
	                </td>
	            </tr>

	        </tbody>
	        </table>

	        <table class="table table-borderless summary">
	        <tbody>
	            <?php 
	                $subtotal = 0;

	                while ($row_items) 
	                {
	                	$subtotal += get_item_total($row_items['price'], $row_items['quantity']); 
	            ?>
	            
	            <tr>
	                <td>
	                    <?php echo $row_items['productName'] ?>
	                </td>
	                <td>
	                    <div style="text-align: center;"><?php echo $row_items['quantity'] ?></div>
	                </td>
	                <td>
		                <div style="text-align: right;">PHP <?php echo number_format(get_item_total($row_items['price'], $row_items['quantity']), 2, '.', ' ');?></div>
		            </td>
	            </tr>

	            <?php
	            		$row_items = $result_items->fetch_assoc();
	                }
	              }    $grandTotal = $row['totalAmount'] + $row['shippingFee'];
	            ?>

	        </tbody>
	        </table><br>

	        <table class="table summary">
	        <tbody>
	            <tr>
			        <td></td><td></td>
	                <td>Subtotal</td>
			        <td>
			            <div style="text-align: right;">
			            	PHP <?php echo number_format($subtotal, 2, '.', ' '); ?>
			            </div>
	                </td>
	            </tr>

	            <tr>
			        <td></td><td></td>
	                <td>Shipping Fee</td>
			        <td>
			            <div style="text-align: right;">
	                        PHP <?php echo number_format($row['shippingFee'], 2, '.', ' '); ?>
	                    </div>
			        </td>
	            </tr>

	            <tr>
	                <td></td><td></td>
	                <th>TOTAL</th>
			        <td>
	                    <div style="text-align: right;">
			                <b>PHP <?php echo number_format($grandTotal, 2, '.', ' ') ?></b>
			            </div>
			        </td>
	            </tr>


	        </tbody>
	        </table>

			<!--BUTTONS-->
			<div class="center" style="margin-left:-10%;">
	            <div class="buttons">
	            	<form method='POST' action='orderDetails.php?orderNo=<?php echo $orderNo?>'>
	                
		                <button type="button" name="updateOrder" onclick="location.href='orderSummary.php?orderNo=<?php echo $orderNo?>'" style="background-color:#2D9CDB;" class="btn btn-one btn-success" >DETAILED ORDER SUMMARY</button>
		                <br>

		                <b>UPDATE SHIPPING FEE</b><br>
		                <input class ="price" type="number" min="0" step="any" name="shippingFee" value="<?php echo $row['shippingFee']; ?>" style="width: 100%; line-height: 2em;"><br><br>

		                <b>UPDATE ORDER STATUS</b><br>
		                <select name="status" class="form-control" style="width: 100%;">
							<option value="pending" <?php if((int)$row['status'] == 1) echo "selected='selected'"?> >Pending</option>
							<option value="approved" <?php if((int)$row['status'] == 2) echo "selected='selected'"?> >Approved</option>
							<option value="packed" <?php if((int)$row['status'] == 3) echo "selected='selected'"?> >Packed</option>
							<option value="shipped" <?php if((int)$row['status'] == 4) echo "selected='selected'"?> >Shipped</option>
							<option value="completed" <?php if((int)$row['status'] == 5) echo "selected='selected'"?> >Completed</option>
							<option value="cancelled" <?php if((int)$row['status'] == 6) echo "selected='selected'"?> >Cancelled</option>
						</select>
						<br>
		                <button type="submit" name="updateBtn" class="btn btn-success submit">Update Order</button>
	            	</form></div>
				</div>
	        <!--END BUTTONS-->
	            <?php
	                }
	            ?>
    	</div>
    </div>
</body>

</html>