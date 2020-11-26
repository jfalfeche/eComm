<!-- PHP SORT BY CATEGORY -->
<?php
    include_once 'database.php';

    if(isset($_GET['id']))
        $cat = $_GET['id'];

   if($cat == 0) {
        $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID ORDER BY product.productID DESC");
    }
    if($cat > 0) {
        $result = mysqli_query($conn,"SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID AND productCategory = ".strval($cat)."");
    }
?>


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
<a href="../products/productDetail.php?action=<?php echo $row['productID']?>" class="text-reset text-decoration-none">
    <div class="col<?php if(sizeof($result) < 4) echo '-md-2';?> card">
        <div class="imgwrap">
            <?php
                echo '<img class="card-img-top img-responsive full-width" src="data:image/jpeg;base64,'.$row['image'].'" alt="Card image cap">';
            ?>
        </div>
        <div class="card-body text-left">
            <h4 class="card-title"><?php echo $row["productName"]; ?></h4>
            <p class="card-text"><b>₱<?php echo $row["price"]; ?></b></p>
            <p class="card-text"><?php echo "Per ".ucwords($row["name"]); ?></p><br><br>
            <a href="#!" class="btn btn-primary">
                <img src="../media/cart.png" alt="cart">
                <h5 class="card-text">Add to Cart</h5>
            </a>
        </div>
    </div>
</a>
    <?php
                if($i == 7) {
                    ?>
                <a href="../product/product.php">
                    <div class="col card last">
                        <div class=" my-auto">
                            <a class="viewmore h-100" href="../products/product.php">
                                <img src="../media/viewmore.png" alt="">
                                <p>View More</p>
                            </a>
                        </div>
                    </div>
                </a>
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