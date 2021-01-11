<?php include 'checkout_method.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout</title>
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

<script type="text/javascript">function getElements(){
        document.getElementById("amount").value = document.getElementById("radio").value;
    }
</script>

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

<form method='POST' action=''>
<div id="container">

    <?php
        $result = $conn->query($customer);
        if (mysqli_num_rows($result) == 1) {
            $row = $result->fetch_assoc();
    ?>

    <div class="column left">
        <div class="header">
            <a href="../cart/cart.php"><i class="fa fa-arrow-circle-left fa-3x" style="color: #200E32;"></i></a>
            <h1 class="underline">SHIPPING INFORMATION</h1>
        </div>

        <table class="table table-bordered">
            <tbody>
                <th scope="col" colspan="2">Personal Details</th>
                <tr><td colspan="2"><?php echo get_customer_name($row['userID']); ?></td></tr>
                <tr>
                    <td><?php echo $row["contactNumber"] ?></td>
                    <td><?php echo $row["customerEmail"] ?></td>
                </tr>

                <tr><th scope="col" colspan="2">Address Details</th></tr>
                <tr><td colspan="2">
                    <input type="radio" id="radio" name="shippingAddress" onclick="getElements()" value="<?php echo $row["permanentAddress"] ?>" />Default Address</td>
                </tr>
                <tr><td colspan="2">
                    <input type="radio" name="shippingAddress" class="radiogroup" checked />Custom Address<br> 

                    <input type="text" placeholder="Custom Address" required style="width: 60%; margin-top: 5px; height: 30px;" name="shippingAddress" id="amount" required/></td>

                </tr>
                
                <tr><th scope="col" colspan="2">Payment Method<br>
                    <select name="paymentMethod">
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="" disabled>--</option>
                    </select></th>
                </tr>
                <tr>     
                    <th scope="col" colspan="2">Message to Seller<br>
                    <textarea name="message" rows="4" cols="60%" required="required"></textarea></th>
                </tr>
            </tbody>
        </table>
    </div>

    <?php
        } //else header("Location: ");
    ?>

    <div class="column right">
        <div class="header"><h1 class="underline">ORDER SUMMARY</h1></div>
        <table class="table table-borderless summary">
        <tbody>
            <?php
                $subtotal = 0;
                $shippingFee = 0;

                $result = $conn->query($items);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                $subtotal += get_item_total($row['price'], $row['quantity']); 
            ?>

            <tr>
                <td>
                    <?php echo $row['productName'] ?>
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

            <tr>
		        <td></td><td></td>
                <td>Shipping Fee</td>
		        <td>
		            <div style="text-align: right;">xxx.xx</div>
		        </td>
            </tr>

            <tr>
                <td></td><td></td>
                <th>TOTAL</th>
		        <td>
                    <div style="text-align: right;">
		                <b>PHP <?php echo number_format($subtotal, 2, '.', ' '); ?></b>
		            </div>
		        </td>
            </tr>
            
        </tbody>
        </table>
        
          <!--BUTTONS-->
        <div class="center">
            <div class="buttons">

                <button type="button" onclick="location.href='../profiles/cartSummary.php?checkout'" style="background-color:#2D9CDB;" class="btn btn-one btn-success">DETAILED ORDER SUMMARY</button>
                <button type="submit" name="submit" class="btn btn-success btn-lg">PLACE ORDER</button>

            </div>
        </div>
        <!--END BUTTONS-->
    </div>
  
</div>
</form>
<!-- Footer -->
    <?php include '../footer/shortfooter.php' ?>
<!-- Footer -->
</body>
</html>