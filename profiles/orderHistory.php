<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
	if(isset($_SESSION['userID']))
		{
			$servername = "localhost";
		    $username = "root";
		    $password = "";
		    $dbname = "philcafe";
		    // Create connection
		    $conn = new mysqli($servername, $username, $password, $dbname);

		    //get buyerID
		    $buyerID =  $_SESSION['userID'];

		    $order = "SELECT * FROM `order` LEFT JOIN  `productDetail` ON order.orderNo = productDetail.orderNo WHERE productDetail.buyerID = '$buyerID' ORDER BY order.dateOrdered DESC, order.orderNo DESC";
		   
		    include 'order_method.php';
		
			//save current page url
		   	$page = $_SERVER["REQUEST_URI"];
			$_SESSION['prevUrl'] = $page;
?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Order History</title>

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
			<form method="post" action="./profile_buyer.php" id="form-id" class="inline" >
				<button type="submit" name="back-btn" id="submit-id" class="inline">
					<i class="fas fa-arrow-circle-left fa-3x inline"></i>
				</button>
			</form>

			<span style="font-size: 2em; font-weight: 500;" class="inline">ORDER HISTORY</span>
			<hr class="mt-1 mb-2">
			
			<div class="sort">
				<form name="sortFormOrder" action="orderHistory.php?buyerID=<?php echo $buyerID;?>" method="post">
					<select name="sortOrder" class="form-control" onChange="sortFormOrder.submit()">
						<option>Sort by</option>
						<option value="all">All</option>
						<option value="oldest-newest">Oldest-Newest</option>
						<option value="newest-oldest">Newest-Oldest</option>
						<option value="pending">Status: Pending</option>
						<option value="approved">Status: Approved</option>
						<option value="packed">Status: Packed</option>
						<option value="shipped">Status: Shipped</option>
						<option value="shipped">Status: Completed</option>
						<option value="shipped">Status: Cancelled</option>

					</select>
				</form>
			</div>
		</div>

		<div id="main">
			<span style="font-size: 12px; font-weight: 500;"><i>click on any item to view details</i></span>
			<table id="order-history-table" class="table table-hover">
				<thead>
					<tr>
					    <th scope="col">ORDER #</th>
					    <th scope="col">STATUS</th>
					    <th scope="col">DATE ORDERED</th>
					    <th scope="col">BUYER</th>
					    <th scope="col">ORDER DETAILS</th>
				    </tr>
				</thead>
				<tbody>
					<?php
						get_order_history();
						$result = $conn->query($order);
		                if ($result->num_rows > 0) 
		                {
		                	$prevOrderNo = null;
		                    // output data of each row
		                    while ($row = $result->fetch_assoc()) 
		                    {
	               				
	                			if($prevOrderNo == $row['orderNo'])
									continue;
									
									$grandTotal = $row['totalAmount'] + $row['shippingFee'];
	                ?>
	                       <tr>
	                            <td>
	                                <?php echo sprintf('%08d', $row['orderNo']) ?>
	                            </td>
	                            <td>
	                            	<span style="color: <?php echo get_status_color($row['status']) ?>;">
	                            	<strong><?php get_status_name($row['status']); ?></strong>
	                            	</span>
	                            </td>
	                            <td>
	                                <?php echo date('d M Y', strtotime($row['dateOrdered'])) ?>
	                            </td>
	                            <td>
	                                <?php get_product_details($row['orderNo']) ?>
	                            </td>
	                            <td>
	                                <div style="text-align: right;">
	                                	<?php echo number_format($grandTotal, 2, '.', ' '); ?>	
	                                	</div>
	                            </td>
	                            <td>
	                            	<a href="../checkout/orderDetails.php?orderNo=<?php echo $row['orderNo']?>" class="btn btn-primary" style="display: none;"></a>
	                            </td>
	                        </tr>
	                       
		                <?php
		                	$prevOrderNo = $row['orderNo'];
		                   	 }

		                	} 
		                	else echo "<tr><td>Order History is empty<td><tr>";
		                	
		                ?>
				</tbody>
			</table>
		</div>
	</div>

</body>
</html>

<script>
	//when a row is clicked, a search is done for the href belonging to an anchor. If one is found, the window’s location is set to that href
	$(document).ready(function() 
	{

	    $('#order-history-table tr').click(function() {
	        var href = $(this).find("a").attr("href");
	        if(href) {
	            window.location = href;
	        }
	    });
	});

</script>

<?php
	}

	else
		header("Location: ../homePage/home.php");

 ?>