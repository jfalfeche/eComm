<?php
        if (isset($_GET['pageno'])) {
            $pageno = intval($_GET['pageno']);
        } else {
            if(isset($pageno))
                {} 
            else
                $pageno = 1;
        }

        if(isset($_GET['id'])) {
            $cat = $_GET['id'];
        } else {
            if(isset($cat))
                {} 
            else {
                $cat = 0;
            }
        } 
// on search
        if(isset($_GET['search']))
            $search = $_GET['search'];
        else
            $search = NULL;

        $no_of_records_per_page = 9;
        $offset = ($pageno-1) * $no_of_records_per_page;

        include_once '../homePage/database.php';

        if($cat == 0) {
            if(isset($search)) {
                $total_pages_sql = "SELECT COUNT(*) FROM product 
                                WHERE product.stock > -1 
                                AND product.productName LIKE '%{$search}%' 
                                OR product.description LIKE '%{$search}%'";
            } else
                $total_pages_sql = "SELECT COUNT(*) FROM product, productunit 
                                    WHERE product.stock > -1 
                                    AND productunit.productUnitID = product.productUnitID";
        }
        if($cat > 0) {
            if(isset($search)) {
                $total_pages_sql = "SELECT COUNT(*) FROM product 
                                    WHERE product.stock > -1 
                                    AND (product.productName LIKE '%{$search}%' 
                                        OR product.description LIKE '%{$search}%') 
                                    AND productCategory = ".strval($cat)."";
            } else
                $total_pages_sql = "SELECT COUNT(*) FROM product, productunit 
                                    WHERE product.stock > -1 
                                    AND productunit.productUnitID = product.productUnitID 
                                    AND productCategory = ".strval($cat)."";
        }
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil(($total_rows / $no_of_records_per_page));

        if($cat == 0) {
            if(isset($search)) {
                $sql = "SELECT * FROM product, productunit WHERE (productunit.productUnitID = product.productUnitID) AND (product.productName LIKE '%{$search}%' OR product.description LIKE '%{$search}%') ORDER BY product.productID DESC LIMIT $offset, $no_of_records_per_page";
            } else
                $sql = "SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID ORDER BY product.productID DESC LIMIT $offset, $no_of_records_per_page";
        }
        if($cat > 0) {
            if(isset($search)) {
                $sql = "SELECT * FROM product, productunit WHERE (productunit.productUnitID = product.productUnitID) AND (productCategory = ".strval($cat).") AND (product.productName LIKE '%{$search}%' OR product.description LIKE '%{$search}%') ORDER BY product.productID DESC LIMIT $offset, $no_of_records_per_page";
            } else
                $sql = "SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID AND (productCategory = ".strval($cat).") ORDER BY product.productID DESC LIMIT $offset, $no_of_records_per_page";
        }
        $res_data = mysqli_query($conn,$sql);
?>

<!-- PAGE NUMBERS START -->
<div class="pageNumbers">
    <button id="1" type="button" class="btn btn-outline-dark">First</button>
    <button id="<?php if($pageno <= 1){ echo '#'; } else { echo ($pageno - 1); } ?>" type="button" class="btn btn-outline-dark"><</button>
    <?php
        for($p = 1; $p <= $total_pages; $p++){ ?>
            <button id="<?php echo $p; ?>" type="button" class="<?php if($p == $pageno) echo 'btn-active'; ?> btn btn-outline-dark"><?php echo $p ?></button>
    <?php        } ?>
    <button id="<?php if($pageno >= $total_pages){ echo '#'; } else { echo ($pageno + 1); } ?>" type="button" class="btn btn-outline-dark">></button>
    <button id="<?php echo $total_pages; ?>" type="button" class="btn btn-outline-dark">Last</button>
</div>
<!-- PAGE NUMBERS END -->

<!-- PRODUCT DISPLAY START -->
<?php
        if (mysqli_num_rows($result) > 0) {
            $i = 1;
            while($row = mysqli_fetch_array($res_data)){
                if ($i == 1 || $i % 4 == 0){
                    echo '<div class="row products">';
                }

                if($row['stock'] > 0)
                {
                ?>
                <a href="../products/productDetail.php?action=<?php echo $row['productID']?>" class="text-reset text-decoration-none">
                    <div class="col-md-3 card">
                        <div class="imgwrap">
                            <?php
                                echo '<img class="card-img-top img-responsive full-width" src="data:image/jpeg;base64,'.$row['image'].'" alt="Card image cap">';
                            ?>
                        </div>
                        <div class="card-body text-left">
                            <h4 class="card-title"><?php echo $row["productName"]; ?></h4>
                            <p class="card-text"><b>₱<?php echo number_format($row["price"], 2, '.', ' '); ?></b></p>
                            <p class="card-text"><?php echo "Per ".ucwords($row["name"]); ?></p><br><br>
                            <a href="../products/productDetail.php?action=<?php echo $row['productID']?>" class="btn btn-primary">
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
                            else
                                continue;
                            }
                        } else {
                            echo "No products found.";
                        }
    ?>
<!-- PRODUCT DISPLAY END -->
<?php
    if(($pageno == $total_pages) && $i <= 3) {
        echo '</div>';
    }
?>
