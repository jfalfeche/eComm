<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Summary</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="../assets/css/cartSummary-style.css">
</head>

<body>
    <!--NAV-->
    <nav class="nav buyer">
        <div class="col-md-2">
            <div class="logo">
                <h1>LOGO</h1>
            </div>
        </div>
        <div class="col-md-3"></div>
        <?php include '../navbar/buyer.php' ?>
    </nav>
    <!--END NAV-->

    <!--HEADER-->
    <div class="header">
        <a href="cart.php"><i class="fa fa-arrow-circle-left fa-2x" style="color: #200E32;"></i></a>
        <h1 class="underline">ORDER SUMMARY</h1>
    </div>
    <!--END HEADER-->


    <!--FOOTER-->
    <?php include '../footer/shortfooter.php' ?>
    <!--END FOOTER-->

</body>
</html>