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
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header>
            <div class="overlay"></div>
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                <source src="media/header.mp4" type="video/mp4">
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

        <nav class="nav guest">
            <div class="col-md-3">
                <div class="logo"><h1>LOGO</h1></div>
            </div>
            <div class="col-md-4"></div>
            <a class="col-md-1 nav-active" href="/homePage/sample.php">Home</a>
            <a class="col-md-1" href="">About</a>
            <a class="col-md-1" href="">Products</a>
            <a class="col-md-1" href="">Contact</a>
            <a class="col-md-1" href="">Login</a>
        </nav>
          
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
                    if(isset($_GET['action']) && $_GET['action'] == 'all') {
                        $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID ORDER BY product.productID DESC");
                        $active = 0;
                    } else if(isset($_GET['action']) && $_GET['action'] == 'fruits') {
                        $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID AND productCategory = '1'");
                        $active = 1;
                    } else if(isset($_GET['action']) && $_GET['action'] == 'vegetables') {
                        $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID AND productCategory = '2'");
                        $active = 2;
                    }
                ?>
                
                <div class="row">
                    <a class="col category <?php if($active == 0) echo 'category-active';?>" href="sample.php?action=all#products">ALL CATEGORIES</a>
                    <a class="col category <?php if($active == 1) echo 'category-active';?>" href="sample.php?action=fruits#products">FRUITS</a>
                    <a class="col category <?php if($active == 2) echo 'category-active';?>" href="sample.php?action=vegetables#products">VEGETABLES</a>
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
                                <img src="media/cart.png" alt="cart">
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
                                                <img src="media/viewmore.png" alt="">
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

        <footer class="container-2">
            <div class="row">
                <div class="col-md-6 left">
                    <a href="">About Us</a><br>
                    <a href="">Products</a><br>
                    <a href="">Login</a><br>
                    <a href="">Register</a>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <a class="col-md-6" href="">Contact Us</a>
                        <a class="col-md-2 flogo" href=""><img src="media/twitterlogo.png" alt=""></a>
                        <a class="col-md-2 flogo" href=""><img src="media/fblogo.png" alt=""></a>
                        <a class="col-md-2 flogo" href=""><img src="media/messengerlogo.png" alt=""></a>
                    </div>
                    <br>
                    <div class="row fcontact">
                        <div class="col-md-2 text-right"><img src="media/officeicon.png" alt=""></div>
                        <div class="col-md-10 fcontacttext">
                            <h6><i>Philippine Agriculture Office</i></h6>
                            <p>1st Floor, Provincial Capitol Building, Cagayan De Oro City,
                            Misamis Oriental 9000 Philippines</p>
                        </div>
                    </div>
                    <div class="row fcontact">
                        <div class="col-md-2 text-right"><img src="media/phoneicon.png" alt=""></div>
                        <div class="col-md-10 fcontacttext">
                            <h6><i>09363961890</i></h6>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <a class="col-md-6" href="">Leave a Message</a>
                    </div>
                </div>
            </div>
            <hr class="footer">
            <p class="text-center">Copyright 2020 PhilCafe. All rights reserved.</p>
        </footer>
    </body>
</html>