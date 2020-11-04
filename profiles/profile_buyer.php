<?php
include_once '../homePage/database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Buyer Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="prof_buyer.css">
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
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

    <div class="header">
        <i class="material-icons md-48 grey">account_circle</i>
        <h1 class="underline">MY ACCOUNT</h1>
    </div>

    <!--links-->
    <div class="center">
        <div class="row text-center">
            <div class="col"><a href="#">
                    <i class="material-icons md-60 red">shopping_cart</i><br>
                    <span>Go To My Cart</span></a>
            </div>

            <div class="col"><a href="#">
                    <i class="material-icons md-60 green">check_circle_outline</i><br>
                    <span>Pending Orders</span></a>
            </div>

            <div class="col"><a href="#">
                    <i class="material-icons md-60 blue">history</i><br>
                    <span>Go To Order History</span></a>
            </div>
        </div>
    </div>
    <!--end links-->

    <div class="container">
        <h2>Personal Profile</h2>

        <div class="info">
            <div class="row">
                <div class="col">
                    <p>Full Name</p>
                </div>
                <div class="col">
                    <p>Gender</p>
             <!--       <p style="color:black;"><?php echo $row["gender"] ?></p> -->
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <p>Email Address</p>
                </div>
                <div class="col">
                    <p>Birthday</p>
                </div>
            </div>

            <p>Mobile</p>
            <p>Address</p>
        </div>

        <!--BUTTONS-->
        <div class="row">
            <div class="buttons">
                <form action="#" method="post"><button type="submit" class="btn btn-success btn-lg btn-block">EDIT PROFILE</button></form>
                <form action="#" method="post"><button type="submit" class="btn btn-success btn-lg btn-block">CHANGE PASSWORD</button></form>
            </div>
        </div>
        <!--END BUTTONS-->
    </div>

    <!--FOOTER-->
    <?php include '../footer/shortfooter.php'; ?>
    <!--END FOOTER-->
</body>

</html>