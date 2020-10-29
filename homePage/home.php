<?php
    include_once 'database.php';
    $active = 0;
    $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID ORDER BY product.productID DESC");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset = "UTF-8" />
        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="../navbar/nav.css">
        <link rel="stylesheet" href="../footer/footer.css">
    </head>
    <body>
        <header>
            <div class="overlay"></div>
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                <source src="./media/header.mp4" type="video/mp4">
            </video>
            <div class="container h-100">
                <div class="d-flex h-100 text-center align-items-center">
                    <div class="w-100 text-white">
                        <h1 class="display-3">PhilCafe</h1>
                        <p class="lead mb-0">Quality Products Picked Specially for You</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- NAV BAR GUEST STARTS HERE -->
        <nav class="nav guest">
            <div class="col-md-3">
                <div class="logo"><h1>LOGO</h1></div>
            </div>
            <div class="col-md-4"></div>
                <?php include '../navbar/guest.php' ?>
        </nav>
        <!-- NAV BAR GUEST ENDS HERE -->
          
        <section class="my-5">
            <div class="container text-center align-items-center">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <h2 id="products">PRODUCTS</h2>
                        <hr>
                    </div>
                </div>

                <!-- PHP SORT BY CATEGORY -->

                <?php
                    if (isset($_GET['action'])){
                        if(intval($_GET['action']) == 0) {
                            $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID ORDER BY product.productID DESC");
                            $active = 0;
                        }
                        for($x = 1; $x <= intval($_GET['action']); $x++){
                            if($_GET['action'] == strval($x)) {
                                $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID AND productCategory = ".strval($x)."");
                                $active = $x;
                            }
                        }
                    }
                ?>
                
                <div class="row">
                    <a class="col category <?php if($active == 0) echo 'category-active';?>" href="home.php?action=0#products">ALL CATEGORIES</a>
                    <a class="col category <?php if($active == 1) echo 'category-active';?>" href="home.php?action=1#products">FRUITS</a>
                    <a class="col category <?php if($active == 2) echo 'category-active';?>" href="home.php?action=2#products">VEGETABLES</a>
                    <a class="col category <?php if($active == 3) echo 'category-active';?>" href="">ROOT CROPS</a>
                    <a class="col category <?php if($active == 4) echo 'category-active';?>" href="">OTHERS</a>
                </div>
                
                <!-- Ideally, every 4 products, a new row of products will be created. 
                    Only up to 7 products are displayed.
                -->    
                <?php
                    $i = 1;
                        if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                            while($row = mysqli_fetch_assoc($result)) {
                                if ($i == 1 || $i % 5 == 0){
                                    echo '<div class="row products">';
                                }
                ?>  
                    <div class="col<?php if(sizeof($result) < 4) echo '-md-2';?> card">
                        <div class="imgwrap">
                            <?php
                                echo '<img class="card-img-top img-responsive full-width" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'" alt="Card image cap">';
                            ?>
                        </div>
                        <div class="card-body text-left">
                            <h4 class="card-title"><?php echo $row["productName"]; ?></h4>
                            <p class="card-text"><b>₱<?php echo $row["price"]; ?></b></p>
                            <p class="card-text"><?php echo $row["name"]; ?></p><br><br>
                            <a href="#!" class="btn btn-primary">
                                <img src="../media/cart.png" alt="cart">
                                <h5 class="card-text">Add to Cart</h5>
                            </a>
                        </div>
                    </div>
                    <?php
                                if($i == 7) {
                                    ?>
                                    <div class="col card last">
                                        <div class=" my-auto">
                                            <a class="viewmore h-100" href="">
                                                <img src="../media/viewmore.png" alt="">
                                                <p>View More</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                    break;
                                }

                                if ($i % 4 == 0 && $i != 0) 
                                    echo '</div>';
                                $i++;
                            }
                        } else {
                            echo "No products found.";
                        }
                ?>
                <!-- PHP END HERE -->

            </div>
        </section>
        
        <?php include '../footer/longfooter.php';?>
    </body>
</html>