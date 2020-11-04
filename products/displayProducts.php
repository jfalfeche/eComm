<!-- PRODUCT DISPLAY START -->
<?php
    include_once '../homePage/database.php';

        if (mysqli_num_rows($result) > 0) {
            $i = 1;
            while($row = mysqli_fetch_array($res_data)){
                if ($i == 1 || $i % 4 == 0){
                    echo '<div class="row products">';
                }
                ?>
                <a href="../products/productDetail.php?action=<?php echo $row['productID']?>" class="text-reset text-decoration-none">
                    <div class="col<?php if(sizeof($result) < 3) echo '-md-2';?> card">
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
                </a>
                    <?php
                                if ($i % 3 == 0 && $i != 0) {
                                    echo '</div>';
                                    $i = 0;
                                }
                                $i++;
                            }
                        } else {
                            echo "No products found.";
                        }
    ?>
<!-- PRODUCT DISPLAY END -->