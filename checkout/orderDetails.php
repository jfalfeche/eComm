<?php include 'orderDetails_method.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Summary</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="./checkout.css">
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

    <div class="column left">
        <div class="header">
            <a href="../profiles/pendingOrders.php"><i class="fa fa-arrow-circle-left fa-3x" style="color: #200E32;"></i></a>
            <h1 class="underline">SHIPPING INFORMATION</h1>
        </div>

        <table class="table table-bordered">

        <?php
            $result = $conn->query($info);
            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
        ?>

            <tbody>
                <th scope="col" colspan="2">Personal Details</th>
                <tr><td colspan="2"><?php echo get_customer_name($row['userID']); ?></td></tr>
                <tr>
                    <td><?php echo $row["contactNumber"] ?></td>
                    <td><?php echo $row["customerEmail"] ?></td>
                </tr>

        <?php
            } $result = $conn->query($info2);
                if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
        ?>

                <tr><th scope="col" colspan="2">Address Details</th></tr>
                <tr><td colspan="2"><?php echo $row["shippingAddress"] ?></td></tr>
                
                <tr><th scope="col" colspan="2">Payment Method</th></tr>
                <tr><td colspan="2"><?php echo $row["paymentMethod"] ?></td></tr>
                
                <tr><th scope="col" colspan="2">Message to Seller</th></tr>
                <tr><td colspan="2"><?php echo $row["message"] ?></td> </tr>
            </tbody>
        </table>
    </div>

    <?php 
        } $result = $conn->query($total);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>

    <div class="column right">
        <div class="header"><h1 class="underline">ORDER SUMMARY</h1></div>
        <table class="table table-borderless summary">
        <tbody>
            <tr>
                <th>ORDER NUMBER</th>
                <td></td><td></td>
                <th><?php echo sprintf('%08d', $row['orderNo']) ?></th>
            </tr>
            <tr>
                <th>ORDER STATUS</th>
                <td></td><td></td>
                <td><span style="color: <?php echo get_status_color($row['status']) ?>;">
	                    <strong><?php get_status_name($row['status']); ?></strong>
	                </span>
                </td>
            </tr>

            <?php 
                } $result = $conn->query($items); if ($result->num_rows > 0) {$row = $result->fetch_assoc();
            ?>

            <tr>
                <th>SELLER</th>
                <td></td><td></td>
                <td><?php echo $row["storeName"] ?>
                </td>
            </tr>

        </tbody>
        </table>

        <table class="table table-borderless summary">
        <tbody>
            <?php }
                $subtotal = 0;
                $shippingFee = 0;

                $result = $conn->query($items);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = $result->fetch_assoc()) {

                $subtotal += get_item_total($row['price'], $row['quantity']); 
            ?>
            
            <tr>
                <td>
                    <div style="text-align: center;"><?php echo $row['productName'] ?></div>
                </td>
                <td>
                    <div style="text-align: center;"><?php echo $row['quantity'] ?></div>
                </td>
                <td>
	                <div style="text-align: right;">PHP <?php echo number_format(get_item_total($row['price'], $row['quantity']), 2, '.', ' ');?></div>
	            </td>
            </tr>

            <?php
                }
            }
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

            <?php
		        $result = $conn->query($total);
		            if ($result->num_rows > 0) {
		                $row = $result->fetch_assoc();
		    ?>

            <tr>
		        <td></td><td></td>
                <td>Shipping Fee</td>
		        <td>
		            <div style="text-align: right;">
                        PHP <?php echo number_format($shippingFee, 2, '.', ' '); ?>
                    </div>
		        </td>
            </tr>

            <tr>
                <td></td><td></td>
                <th>TOTAL</th>
		        <td>
                    <div style="text-align: right;">
		                <b>PHP <?php echo number_format($row['totalAmount'], 2, '.', ' ') ?></b>
		            </div>
		        </td>
            </tr>

            <?php
                }
            ?>

        </tbody>
        </table>

        <!--BUTTONS-->
        <div class="center">
            <div class="buttons"><form method='POST' action=''>
                <button type="button" onclick="location.href='../profiles/orderSummary.php?orderNo=<?php echo $orderNo?>'" style="background-color:#2D9CDB;" class="btn btn-one btn-success">DETAILED ORDER SUMMARY</button>
                <button type="submit" name="cancel" class="btn btn-two btn-success btn-lg">Cancel Order</button>
            </div></form>
        </div>
        <!--END BUTTONS-->
    </div>

</div>

<!-- Footer -->
    <?php include '../footer/shortfooter.php' ?>
<!-- Footer -->
</body>
</html>