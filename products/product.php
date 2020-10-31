<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>
        <link rel="icon" href="">
        <link rel="stylesheet" href="product.css">
        <link rel="stylesheet" href="../navbar/nav.css">
        <link rel="stylesheet" href="../footer/footer.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    </head>
    <body>
        <!--NAV-->
        <nav class="nav guest fixed-top">
            <div class="col-md-2">
                <div class="logo">
                    <h1>LOGO</h1>
                </div>
            </div>
            <div class="col-md-5"></div>
            <?php include '../navbar/guest.php' ?>
        </nav>
        <!--END NAV-->

        <header class="row">
            <div class="col d-flex justify-content-center my-auto">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search products here..." aria-label="" aria-describedby="basic-addon1">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="button">Search <i class="fas fa-search"></i> </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="container align-items-center w-100 my-5">
            <div class="row">
                <div class="col-md-4 categories text-center">
                    <div class="category"><a class="category-active" href="#products" id="0">ALL CATEGORIES</a></div>
                    <div class="category"><a class="" href="#products" id="1">FRUITS</a></div>
                    <div class="category"><a class="" href="#products" id="2">VEGETABLES</a></div>
                    <div class="category"><a class="" href="#products" id="3">ROOT CROPS</a></div>
                    <div class="category"><a class="" href="#products" id="4">OTHERS</a></div>
                </div>
                <div class="col-md-8 products text-center">Test</div>
            </div>
        </div>
        
        <?php include '../footer/longfooter.php';?>
    </body>
</html>