<!DOCTYPE html>
<html lang="en">
<body>
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
        <div class="col card">
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
                        <div class="col card">
                            <div class="my-auto">
                                <a class="viewmore h-100" href="">
                                    <img src="media/viewmore.png" alt="">
                                    <p>View More</p>
                                </a>
                            </div>
                        </div>
                        <?php
                    }

                    if ($i % 4 == 0 && $i != 0)
                        echo '</div>';
                    $i++;
                }
            } else {
                echo "0 results";
            }
    ?>
    <!-- PHP END HERE -->
</body>
</html>