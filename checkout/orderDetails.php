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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="./checkout.css">

    <script>
        function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
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

<!--START MODAL-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Order Cancellation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>You are about to cancel your order, this procedure is irreversible.</p>
        <p>Do you want to proceed?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <form method='POST' action=''><a><button type="submit" name="cancel" class="btn btn-danger btn-ok">Cancel Order</button></a></form>
      </div>
    </div>
  </div>
</div>
<!--END MODAL-->

<div id="container">

    <div class="column left">
        <div class="header">
            <a href="<?php echo $_SESSION['prevUrl'];?>">
                <i class="fa fa-arrow-circle-left fa-3x" style="color: #200E32;"></i></a>
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
                } $result = $conn->query($items); if ($result->num_rows > 0) {$row = $result->fetch_assoc();
            ?>

            <tr>
                <th style="line-height: 3px;">SELLER</th>
                <td></td><td></td>
                <td style="line-height: 3px;"><?php echo $row["storeName"] ?>
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
                    <div style="text-align: right;"><?php echo $row['productName'] ?></div>
                </td>
                <td>
                    <div style="text-align: right;"><?php echo $row['quantity'] ?></div>
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
                        
                $grandTotal = $row['totalAmount'] + $row['shippingFee'];
		    ?>

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

            <?php
                }
            ?>

        </tbody>
        </table>

        <!--BUTTONS-->
            <div class="buttons" style="margin-left:10%;">
                <button type="button" onclick="location.href='../profiles/orderSummary.php?orderNo=<?php echo $orderNo?>'" style="background-color:#2D9CDB;" class="btn btn-one btn-success">DETAILED ORDER SUMMARY</button>
                <br>
                <?php 
                    if($row['status'] == 1) {?>
                <button type="button" class="btn btn-two" data-toggle="modal" data-target="#exampleModal">Cancel Order</button>
                <?php }?>
            </div>
        <!--END BUTTONS-->
    </div>

</div>

<!-- Footer -->
    <?php include '../footer/shortfooter.php' ?>
<!-- Footer -->
</body>
</html>