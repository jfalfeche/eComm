<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $page = $_SERVER["REQUEST_URI"];
    $_SESSION['cartUrl'] = $page;
    $_SESSION['urlBeforeCart'] = $_SESSION['prevUrl'];
	$_SESSION['prevUrl'] = $page;
    if (isset($_SESSION['userID'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "philcafe";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        $userID =  $_SESSION['userID'];

        $sql = "SELECT * FROM productdetail INNER JOIN sellers on productdetail.sellerID = sellers.sellerID INNER JOIN product on productdetail.productID = product.productID INNER JOIN productunit on product.productUnitID = productunit.productUnitID WHERE (buyerID = $userID AND inOrder = 0) ORDER BY productDetail.productDetailID ASC";
        $result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="../assets/css/order-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/editProduct.css">
    <link rel="stylesheet" href="./cart.css">

    <script> // initialize array to store values
        $.noConflict();
        window.stock = new Array();
        window.price = new Array();
        window.product = new Array();
        window.quantity = new Array();
        window.total = new Array();
    </script>
    <script src="./o_cart.js"></script>
</head>
<body>
    <div id="checker" style="display: none; visibility: hidden;"></div>
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

    <!--START: DELETE MODAL-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModal">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">&times;</button>
                </div>
            
                <div class="modal-body">
                    <p>You are about to remove a product from your cart, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
	<!--END: DELETE MODAL-->

    <div id="container">
		<div id="title">
            <div class="back">
                <a href="<?php echo $_SESSION['urlBeforeCart'];?>" class="text-decoration-none" >
                    <i class="fa fa-arrow-circle-left fa-3x"></i>&nbsp;
                </a>
                <span style="font-size: 2em; font-weight: 500;" class="inline">YOUR CART</span>
                <hr class="mt-1 mb-2">
            </div>
		</div>

        <div id="main">
			<table id="pending-orders-table" class="table table-hover">
				<thead>
					<tr>
					    <th scope="col">SOLD BY</th>
					    <th scope="col">PRODUCT</th>
					    <th scope="col">PRICE</th>
					    <th scope="col">QUANTITY</th>
					    <th scope="col">TOTAL</th>
				    </tr>
				</thead>
				<tbody>
                    <script> var x = 0; // initialize x</script> 
					<?php
		                if ($result->num_rows > 0) 
		                {
                            // output data of each row
                            $x = 0;
		                    while ($row = mysqli_fetch_array($result)) {
	                ?>
                        <script> // set array values
                            stock[x] = <?php echo $row['stock']; ?>;
                            price[x] = <?php echo $row['price']; ?>;
                            product[x] = <?php echo $row['productID']; ?>;
                            quantity[x] = <?php echo $row['quantity']; ?>;
                        </script>
	                        <tr>
	                            <td> <!-- SOLD BY -->
                                    <a href="../profiles/profile_store.php?sellerID=<?php echo $row["sellerID"] ?>">
                                        <?php echo $row['storeName']; ?>
                                    </a>
	                            </td>
	                            <td> <!-- PRODUCT NAME -->
                                <a href="../products/productDetail.php?action=<?php echo $row['productID']?>">
                                    <?php echo $row['productName']; ?>
                                </a>
	                            </td>
	                            <td> <!-- PRICE -->
	                                <?php echo "PHP ". number_format($row['price'], 2, '.', ' ')." per ".$row['name'] ?>
	                            </td>
	                            <td> <!-- QUANTITY -->
                                    <div class="def-number-input number-input" id="quan">
                                        <button id="0<?php echo $x ?>" class="minus"></button>
                                        <input id="quantity<?php echo $x ?>" class="quantity" min="1" name="quantity<?php echo $x ?>" value="<?php echo $row['quantity']; ?>" type="number">
                                        <button id="1<?php echo $x ?>" class="plus"></button>
                                    </div>
	                            </td>
	                            <td> <!-- TOTAL -->
                                    <p id="total<?php echo $x ?>" style="text-align: right;">
                                        <script>
                                            total[x] = <?php echo $row['price'] * $row['quantity']; ?>
                                        </script>
                                        <?php echo  number_format($row['price'] * $row['quantity'], 2, '.', ' '); ?>
                                    </p>
                                </td>
                                <td>
                                    <button type="submit" class="btn fas fa-times-circle fa-2x" data-href="cart_delete.php?productID=<?php echo $row['productID'] ?>" data-toggle="modal" data-target="#confirm-delete" id="delModal">	</button>
                                </td>
	                        </tr>
                            <?php $x++; ?>
                            <script> x++; // increment x</script>   
                        <?php } ?><!-- close while loop -->
                        <!-- Display overall total -->
                        <tr id="gTotal">
                            <td>
                                <h1>TOTAL</h1>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <h3 id="grandTotal" style="text-align: right;"></h3>
                                <script> 
                                    updateGrandTotal();
                                </script>
                            </td>
                            <td></td>
                        </tr>
                <?php    } else echo "Cart is empty";
                ?>
				</tbody>
			</table>
		</div>
        <!-- Buttons here -->
        <div class="row">
            <div class="col-md-12 buttons">
               <button type="button" onclick="location.href='../profiles/cartSummary.php'" class="btn btn-success submit" id="summary">VIEW CART SUMMARY</button><br>
                <button type="button" onclick="location.href='../checkout/checkout.php'"class="btn btn-success submit" id="checkout">PROCEED TO CHECKOUT</button>
            </div>
        </div>
    </div>
                
    <!-- Footer -->
    <?php include '../footer/shortfooter.php' ?>
    <!-- Footer -->
    <?php 
        } else
        header("Location:../homePage/home.php");
    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        })
    </script>
</body>
</html>