<?php
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "philcafe";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); 

	if (isset($_GET['pageno'])) 
	{
        $pageno = intval($_GET['pageno']);
    } 
    else 
    {
        if(isset($pageno))
            {} 
        else
            $pageno = 1;
    }



	$no_of_records_per_page = 12;
	$offset = ($pageno-1) * $no_of_records_per_page;

	$total_pages_sql = "SELECT COUNT(*) FROM `product` WHERE seller = $sellerID";

	$result = mysqli_query($conn,$total_pages_sql);
	$total_rows = mysqli_fetch_array($result)[0];
	$total_pages = ceil(($total_rows / $no_of_records_per_page));

	$products = "SELECT * from `product`, `productUnit` WHERE (productUnit.productUnitID = product.productUnitID) AND (product.seller=$sellerID) LIMIT $offset, $no_of_records_per_page";

	if(isset($_POST['srchProduct'])){
        search_products($_POST['searchProductsVal']);
        unset($_POST['srchProduct']);
    }

	$result_products = mysqli_query($conn, $products);

    $products = "SELECT * from `product`, `productUnit` WHERE (productUnit.productUnitID = product.productUnitID) AND (product.seller=$sellerID) LIMIT $offset, $no_of_records_per_page";

?>



<div class ="products-display">
<br>
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
<br>

<?php 
	if ($result->num_rows > 0) 
    {
        $i = 1;

        
        while($row = mysqli_fetch_array($result_products)){
            if ($i == 1 || $i % 5 == 0){
                echo '<div class="row stores">';
            }
            ?>

            <a href="../products/productDetail.php?action=<?php echo $row['productID']?>" class="text-reset text-decoration-none">
                <div class="col<?php if($result_products->num_rows < 4) echo '-md-2';?> card">
                    <div class="imgwrap">
                        <?php
                            echo '<img class="card-img-top img-responsive full-width" src="data:image/jpeg;base64,'.$row['image'].'" alt="Card image cap">';
                        ?>
                    </div>
                    <div class="card-body text-left">
                        <h4 class="card-title"><?php echo $row["productName"]; ?></h4>
                        <p class="card-text"><b>₱<?php echo $row["price"]; ?></b></p>
                        <p class="card-text"><?php echo "Per ".ucwords($row["name"]); ?></p><br>
                        <p class="card-text">Available Stock: &emsp; <span style="font-weight: 500; text-align: right;"><?php echo ucwords($row["stock"]); ?></span></p>
                        <br><br>

                        <div id="product-buttons"class="row">
                            <a href="editProduct.php?productID=<?php echo $row['productID']?>" class="btn btn-info col-6">
                                <h5 class="card-text">Update</h5>
                            </a>
                            <a class=" btn btn-danger col-4" data-product="<?php echo $row['productName'] ?>" data-href="deleteProduct.php?productID=<?php echo $row['productID'] ?>"  data-toggle="modal" data-target="#confirm-delete-product" id="delModal"
                            >
                                <i class="fas fa-trash-alt fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </a>

<?php
            if ($i % 4 == 0 && $i != 0) {
                echo '</div>';
                $i = 0;
            }
            $i++;
        
    	} 
    }else {
        echo "<span style=\"color: red;\">No products found.</span>";
    }
?>

</div>


	

