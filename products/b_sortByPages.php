<html>
<head>
    <title>Pagination</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="../assets/css/productCard.css">
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
</head>
<body>
    <?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 9;
        $offset = intval($pageno-1) * $no_of_records_per_page;

        $conn=mysqli_connect("localhost","root","","philcafe");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql = "SELECT COUNT(*) FROM product, productunit WHERE productunit.productUnitID = product.productUnitID";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil(($total_rows / $no_of_records_per_page));

        $sql = "SELECT * FROM product, productunit WHERE productunit.productUnitID = product.productUnitID ORDER BY product.productID DESC LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
?>

<!-- PAGE NUMBERS START -->
    <?php 
        echo "<a href=\"?pageno=1\"><button type=\"button\" class=\"btn btn-outline-dark\">First</button></a>";
        echo "<a href=";?><?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?><?php echo "><button type=\"button\" class=\"btn btn-outline-dark\"><</button></a>";
        for($p = 1; $p <= $total_pages; $p++){
            echo "<a href=\"?pageno=".$p."\"><button type=\"button\" class=\"btn btn-outline-dark\">".$p."</button></a>";
        }
        echo "<a href=";?><?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?><?php echo "><button type=\"button\" class=\"btn btn-outline-dark\">></button></a>";
        echo "<a href=\"?pageno=".$total_pages."\"><button type=\"button\" class=\"btn btn-outline-dark\">Last</button></a>";
    ?>
<!-- PAGE NUMBERS END -->

<!-- PRODUCT DISPLAY START -->
<?php
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
</body>
</html>