<?php include('method_seller.php'); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Seller Registration</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="reg.css">
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
</head>

<body>
    <!--NAV-->
    <nav class="nav guest">
        <div class="col-md-1">
            <div class="logo">
                <h1>LOGO</h1>
            </div>
        </div>
        <div class="col-md-6"></div>
        <?php include '../navbar/guest.php' ?>
    </nav>
    <!--END NAV-->

    <h2 class="text-center">Register as PhilCafe Seller</h2>
    <hr class="solid">

    <!--REG FORM-->
    <div class="signup-form">
        <form method='post' action=''>

            <?php
            // Display Error message
            $error_message;
            $success_message;

            if (!empty($error_message)) {
            ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> <?= $error_message ?>
                </div>

            <?php
            }
            ?>

            <?php
            // Display Success message
            if (!empty($success_message)) {
            ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?= $success_message ?>
                </div>

            <?php
            }
            ?>

            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <p>Store Name</p><input type="text" class="form-control" name="storeName" placeholder="MyShop" required="required">
                    </div>
                    <div class="col">
                        <p>Email Address</p><input type="text" class="form-control" name="storeEmail" placeholder="sample_email2020@gmail.com" required="required">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <p>Store Description</p>
                <textarea name="storeDescription" class="form-control" placeholder="" rows="7" required="required"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-success btn-lg btn-block">Apply as Seller</button>
        </form>
    </div>
    <!--END OF REG FORM-->

    <!--FOOTER-->
    <?php include '../footer/shortfooter.php'; ?>
    <!--END FOOTER-->
</body>

</html>