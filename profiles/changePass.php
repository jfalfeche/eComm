<?php include('changePass_method.php');?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Buyer Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../assets/css/changePass.css">
        <link rel="stylesheet" href="../navbar/nav.css">
        <link rel="stylesheet" href="../footer/footer.css">
    </head>

    <body>
        <!--NAV-->
        <nav class="nav buyer">
            <div class="col-md-3">
                <div class="logo">
                    <img class="imglogo" src="../assets/img/philcafe.png" alt="">
                    <h1 class="logotitle">PhilCafe</h1>
                </div>
            </div>
            <div class="col-md-2"></div>
            <?php include '../navbar/buyer.php' ?>
        </nav>
        <!--END NAV-->

        <div class="header">
            <a href="profile_buyer.php"><i class="fa fa-arrow-circle-left fa-3x" style="color: #200E32;"></i></a>
            <h1 class="underline">CHANGE PASSWORD</h1>
        </div>

        <div class="container">
            <form action="#" method="post">
           
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
            
                <div class="info">
                    <table>
                        <tr>
                            <td>Current Password</td>
                            <td><input type="password" class="form-control" name="currPassword" required="required"></td>
                        </tr>
                        <tr>
                            <td>New Password</td>
                            <td><input type="password" class="form-control" name="password" required="required"></td>
                        </tr>
                        <tr>
                            <td>Confirm Password</td>
                            <td><input type="password" class="form-control" name="confirmPassword" placeholder="*minimum of 8 characters" required="required" minlength="8"></td>
                        </tr>
                    </table>
                </div>

                <button type="submit" name="update" class="btn btn-success">SAVE CHANGES</button>
            </form>
        </div>

        <!--FOOTER-->
        <?php include '../footer/shortfooter.php'; ?>
        <!--END FOOTER-->
    </body>

    </html>