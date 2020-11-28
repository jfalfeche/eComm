<?php
session_start();
if (isset($_SESSION['userID'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "philcafe";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $userID =  $_SESSION['userID'];
    $sql = "SELECT password FROM customers WHERE userID=$userID LIMIT 1";
    $result = $conn->query($sql);

    include 'changePass_method.php';
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Buyer Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="pass_buyer.css">
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
            <a href="profile_buyer.php"><i class="fa fa-arrow-circle-left fa-2x" style="color: #200E32;"></i></a>
            <h1 class="underline">CHANGE PASSWORD</h1>
        </div>

        <div class="container">
            <form action="#" method="post">
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

<?php
} else header("Location: profile_buyer.php");
?>