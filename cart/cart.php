<?php
    session_start();
    if (isset($_SESSION['userID'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "philcafe";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        $userID =  $_SESSION['userID'];

        $sql = "SELECT * FROM productdetail INNER JOIN sellers on productdetail.sellerID = sellers.sellerID INNER JOIN product on productdetail.productID = product.productID INNER JOIN productunit on product.productUnitID = productunit.productUnitID WHERE (buyerID = $userID AND inOrder = 0)";
        $result = mysqli_query($conn,$sql);
    }
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

    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="../assets/css/order-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/editProduct.css">
    <link rel="stylesheet" href="../cart/cart.css">

    <script> // initialize array to store values
        window.stock = new Array();
        window.price = new Array();
        window.product = new Array();
        window.quantity = new Array();
    </script>
</head>
<body>
    <!--NAV-->
    <nav class="nav buyer">
        <div class="col-md-2">
            <div class="logo">
                <h1>LOGO</h1>
            </div>
        </div>
        <div class="col-md-3"></div>
        <?php include '../navbar/buyer.php' ?>
    </nav>
        <!--END NAV-->

    <div id="container">
		<div id="title">
			<form method="post" action="storeProfile.php?sellerID=<?php echo $sellerID;?>" id="form-id" class="inline" >
				<button type="submit" name="back-btn" id="submit-id" class="inline">
					<i class="fas fa-arrow-circle-left fa-3x inline"></i>
				</button>
			</form>

			<span style="font-size: 2em; font-weight: 500;" class="inline">YOUR CART</span>
			<hr class="mt-1 mb-2">
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
	                                <?php echo $row['storeName']; ?>
	                            </td>
	                            <td> <!-- PRODUCT NAME -->
	                            	<?php echo $row['productName']; ?>
	                            </td>
	                            <td> <!-- PRICE -->
	                                <?php echo "PHP ".$row['price']." per ".$row['name'] ?>
	                            </td>
	                            <td> <!-- QUANTITY -->
                                    <div class="def-number-input number-input" id="quan">
                                        <button id="0<?php echo $x ?>" class="minus"></button>
                                        <input id="quantity<?php echo $x ?>" class="quantity" min="1" name="quantity<?php echo $x ?>" value="<?php echo $row['quantity']; ?>" type="number">
                                        <button id="1<?php echo $x ?>" class="plus"></button>
                                    </div>
	                            </td>
	                            <td> <!-- TOTAL -->
                                    <p id="total<?php echo $x ?>">
                                        <?php echo $row['price'] * $row['quantity']; ?>
                                    </p>
	                            </td>
	                        </tr>
                            <?php $x++; ?>
                            <script> x++; // increment x</script>   
                        <?php } // close while loop?> 
				</tbody>
			</table>
		</div> 
    </div>
                <?php
                    } 
                    else echo "Database is empty";
                ?>
    <!-- Footer -->
    <?php include '../footer/shortfooter.php' ?>
    <!-- Footer -->
    <script>
        function updateTotal(q) {
            var total = document.getElementById(`total${q}`);
            total.innerHTML = document.getElementById(`quantity${q}`).value * price[parseInt(q)];
        }

        function updateDatabase(q) {
            var x = product[parseInt(q)];
            var y = document.getElementById(`quantity${q}`).value;
            $.get('update_cart.php',
            {
                update:'true',
                action:x, 
                quantity:y
            }, function(d){
                $(`#quantity${q}`).html(d);
            });
        }

        function updateStock(q) { // update stock array value
            if(parseInt(document.getElementById(`quantity${q}`).value) > quantity[parseInt(q)])
                stock[parseInt(q)] = stock[parseInt(q)] - (parseInt(document.getElementById(`quantity${q}`).value) - quantity[parseInt(q)]);
            else
                stock[parseInt(q)] = stock[parseInt(q)] + (quantity[parseInt(q)] - parseInt(document.getElementById(`quantity${q}`).value));
        }

        function updateAll(q) {
            updateTotal(q);
            updateDatabase(q);
            updateStock(q);
            quantity[parseInt(q)] = parseInt(document.getElementById(`quantity${q}`).value);
        }

        document.addEventListener("DOMContentLoaded", function () 
        {
            $('button').on('click', function(e){
                e.preventDefault();
                q = this.id.substring(1);
                if (this.id.charAt(0) == '0') {
                    if(parseInt(document.getElementById(`quantity${q}`).value) <= 1) {
                        alert("Invalid quantity.");
                        return;
                    } else
                        document.getElementById(`quantity${q}`).stepDown();
                } else if (this.id.charAt(0) == '1') {
                    if(parseInt(document.getElementById(`quantity${q}`).value) >= (quantity[parseInt(q)] + stock[parseInt(q)])) {
                        alert("Invalid quantity.");
                        return;
                    } else
                        document.getElementById(`quantity${q}`).stepUp();
                }
                updateAll(q);
            })

            $('input').on('keyup', function() {
                q = this.id.substring(8); // id no
                
                if(parseInt(this.value) >= 1){

                } else {
                    alert("Invalid quantity.");
                    this.value = 1;
                }

                if(parseInt(this.value) > (quantity[parseInt(q)] + stock[parseInt(q)])) {
                    alert("Invalid quantity.");
                    this.value = quantity[parseInt(q)] + stock[parseInt(q)];
                }
                updateAll(q);
            }) 
        })
    </script>
</body>
</html>