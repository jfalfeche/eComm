<?php
    session_start();
    $page = $_SERVER["REQUEST_URI"];
	$_SESSION['prevUrl'] = $page;
    if (isset($_SESSION['userID'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "philcafe";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        $userID =  $_SESSION['userID'];

        $sql = "SELECT * FROM customers WHERE userID=$userID LIMIT 1";
        $result = $conn->query($sql);

        function get_customer_name($userID)
        {
            global $conn;

            $sql = "SELECT firstName, middleName, lastName FROM `customers` WHERE userID=$userID LIMIT 1";
            $result = $conn->query($sql);

            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
                $name = $row['firstName'] . " " . $row['middleName'] . " " . $row['lastName'];
                echo ($name);
            }
        }

        function hide_mail($customerEmail)
        {
            $mail_part = explode("@", $customerEmail);
            $mail_part[0] = substr($customerEmail, 0, 4) . str_repeat("*", strlen($mail_part[0]) - 4);
            return implode("@", $mail_part);
        }

        function hide_mobile($contactNumber)
        {

            $mask_number =  str_repeat("*", strlen($contactNumber) - 4) . substr($contactNumber, -4);
            return $mask_number;
        } 
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Buyer Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../assets/css/profileBuyer.css">
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
            <i class="material-icons md-48 grey">account_circle</i>
            <h1 class="underline">MY ACCOUNT</h1>
        </div>

        <!--links-->
        <div class="center">
            <div class="row text-center">
                <div class="col"><a href="../cart/cart.php">
                        <i class="material-icons md-60 red">shopping_cart</i><br>
                        <span>Go To My Cart</span></a>
                </div>

                <div class="col"><a href="pendingOrders.php?buyerID=<?php echo $userID; ?>">
                        <i class="material-icons md-60 green">check_circle_outline</i><br>
                        <span>Pending Orders</span></a>
                </div>

                <div class="col"><a href="orderHistory.php?buyerID=<?php echo $userID; ?>">
                        <i class="material-icons md-60 blue">history</i><br>
                        <span>Go To Order History</span></a>
                </div>
            </div>
        </div>
        <!--end links-->

        <div class="container">

            <?php
            if (mysqli_num_rows($result) == 1) {
                $row = $result->fetch_assoc();
            ?>

                <h2>Personal Profile</h2>

                <div class="info">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td style="color:#787575;">Full Name</td>
                                <td><?php get_customer_name($row['userID']); ?></td>
                                <td style="color:#787575;">Gender</td>
                                <td><?php echo $row["gender"] ?></td>
                            </tr>
                            <tr>
                                <td style="color:#787575;">Email Address</td>
                                <td><?php echo hide_mail($row["customerEmail"]) ?></td>
                                <td style="color:#787575;">Birthday</td>
                                <td><?php echo $row["birthday"] ?></td>
                            </tr>
                            <tr>
                                <td style="color:#787575;">Mobile</td>
                                <td><?php echo hide_mobile($row["contactNumber"]) ?></td>
                            </tr>
                            <tr>
                                <td style="color:#787575;">Address</td>
                                <td><?php echo $row["permanentAddress"] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            <?php
            } else header("Location: ../homePage/home.php");
            ?>

            <!--BUTTONS-->
            <div class="row box">
                <div class="buttons">
                    <form action="editProfile.php" method="post"><button type="submit" class="btn btn-success">EDIT PROFILE</button></form>
                    <form action="changePass.php" method="post"><button type="submit" class="btn btn-success">CHANGE PASSWORD</button></form>
                </div>
            </div>
            <!--END BUTTONS-->
        </div>

        <!--FOOTER-->
        <?php include '../footer/shortfooter.php'; ?>
        <!--END FOOTER-->
    </body>

    </html>

<?php
} else header("Location: ../homePage/home.php");
?>