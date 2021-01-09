<?php
    session_start();
    include '../homePage/database.php';
    include '../cart/add_to_cart.php';
    if(isset($_GET['action'])) {
        $id =  $_GET['action'];
    }
    //
    if(isset($_SESSION['cartUrl'])) {
        if($_SESSION['prevUrl'] != $_SESSION['cartUrl']) {
            $_SESSION['back'] = $_SESSION['prevUrl'];
        }
    } else $_SESSION['back'] = $_SESSION['prevUrl'];
    $_SESSION['prevUrl'] = $_SERVER["REQUEST_URI"];
    //

    $sql = "SELECT * FROM product, productunit, sellers WHERE product.productID = ".$id." AND productunit.productUnitID = product.productUnitID AND product.seller = sellers.sellerID";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) > 0) {
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['productName']; ?></title>
    <link rel="icon" href="">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/editProduct.css">
    <link rel="stylesheet" href="./productDetail.css">
</head>
<body>
    <!--NAV-->
    <nav class="nav guest">
        <div class="col-md-3">
            <div class="logo">
                <img class="imglogo" src="../assets/img/philcafe.png" alt="">
                <h1 class="logotitle">PhilCafe</h1>
            </div>
        </div>
        <?php 
            if (isset($_SESSION['userID'])){
        ?>
        <div class="col-md-2"></div>
        <?php 
                include '../navbar/buyer.php';
            } else {
        ?>
        <div class="col-md-4"></div>
        <?php
                include '../navbar/guest.php';}
        ?>
    </nav>
    <!--END NAV-->

    <div class="back">
        <a href="<?php echo $_SESSION['back'];?>" class="text-decoration-none" >
            <i class="fa fa-arrow-circle-left fa-3x"></i>&nbsp;
        </a>
        <div class="title">
            <h1>Product Detail</h1>
            <hr>
        </div>
    </div>

    <div class="productDetails">
        <div class="imgwrap">
            <?php 
                echo '<img class="productImg img-responsive full-width" src="data:image/jpeg;base64,'.$row['image'].'" alt="Card image cap">';
            ?>
        </div>
        <div class="productInfo">
            <h1>
                <?php echo strtoupper($row['productName']) ?>
            </h1>
            <p>
                <span class="price"><b>₱<?php echo $row["price"]; ?></b></span>
                <span class="unit"><?php echo "Per ".ucwords($row["name"]); ?></span>
            </p>
            <p>
                Product Code: <b><?php echo $row["productID"] ?></b>
            </p>
            <p>
                Sold By: <a href="../profiles/profile_store.php?sellerID=<?php echo $row["sellerID"] ?>"><b><?php echo $row["storeName"] ?></b></a>
            </p>
            <p>
                Product Description:
                <p class="description">
                    <?php echo $row["description"] ?>
                </p>
            </p>
            <form method="post" action="productDetail.php?action=<?php echo $id ?>" id="addtocartform" enctype="multipart/form-data">
                <p>
                    Quantity:
                    <div class="def-number-input number-input" id="quan">
                        <button id="0" class="minus"></button>
                        <input id="quantity" class="quantity" min="1" name="quantity" value="1" type="number">
                        <button id="1" class="plus"></button>
                    </div>
                    <div id="avail">
                        <?php 
                            echo $row["stock"]." ".strtolower($row["name"]); if($row["stock"] > 1) echo "s";
                        ?> available
                    </div>
                </p>
                <br>
                <button id="addtocart" name="submit-button" href="" class="btn btn-primary">
                    <img class="cartIcon" src="../media/cart.png" alt="cart">
                    <h5 class="cartText">Add to Cart</h5>
                </button>
            </form>
        </div>
        
    </div>

    <script>
        var form = document.getElementById("addtocartform");
        $('button#addtocart').on('click', function(e){
            form.submit();
        })

        $('button#0').on('click', function(e){
            e.preventDefault();
            var count = document.getElementById("quantity").value;
            if(count > 1) {
                document.getElementById("quantity").stepDown();
            }
        })
        $('button#1').on('click', function(e){
            e.preventDefault();
            var count = document.getElementById("quantity").value;
            if(count >= 1 && count < <?php echo $row["stock"] ?>) {
                document.getElementById("quantity").stepUp();
            }
        })
        var quant = document.getElementById("quantity");
        quant.addEventListener('keyup', function() {
            if(quant.value > <?php echo $row["stock"] ?>)
                quant.value = <?php echo $row["stock"] ?>;
            else if (quant.value < 1)
                quant.value = 1;
        })
    </script>

    <div class="whiteSquare"></div>

    <div class="bottom">
        <?php include '../footer/shortfooter.php';?>
    </div>
    <?php
        } else
            header("Location: ../products/product.php");
    ?>
</body>
</html>