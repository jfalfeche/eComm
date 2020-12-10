<?php include('editProfile_method.php');?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Buyer Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="editProfile.css">
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
            <h1 class="underline">EDIT PROFILE</h1><i class="material-icons md-35 icon">edit</i>
        </div>

        <div class="container">
            <form action="#" method="post">
                <?php
                if (mysqli_num_rows($result) == 1) {
                    $row = $result->fetch_assoc();
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
                        <div class="floatLeft">
                            <table>
                                <tr>
                                    <td>First Name</td>
                                    <td><input type="text" class="form-control" name="firstName" value="<?php echo $row["firstName"] ?>" required="required"></td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td><input type="text" class="form-control" name="lastName" value="<?php echo $row["lastName"] ?>" required="required"></td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td><input type="text" class="form-control" name="customerEmail" placeholder="<?php echo hide_mail($row["customerEmail"]) ?>" required="required"></td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td><input type="text" class="form-control" name="contactNumber" placeholder="<?php echo hide_mobile($row["contactNumber"]) ?>" required="required"></td>
                                </tr>
                            </table>
                        </div>

                        <div class="floatRight">
                            <table>
                                <tr>
                                    <td>Middle Name</td>
                                    <td><input type="text" class="form-control" name="middleName" value="<?php echo $row["middleName"] ?>" required="required"></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>
                                        <label class="radio-inline one">
                                            <input type="radio" name="gender" value="female" required>Female
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" value="male">Male
                                        </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Birthday</td>
                                    <td><input type="date" class="form-control" name="birthday" value="<?php echo $row["birthday"] ?>" required="required"></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><textarea class="form-control" name="permanentAddress" placeholder="<?php echo $row["permanentAddress"] ?>" rows="3" required="required"></textarea></td>
                                </tr>
                            </table>
                        </div>

                    </div>

                <?php
                } else header("Location: profile_buyer.php");
                ?>

                <button type="submit" name="update" class="btn btn-success">SAVE CHANGES</button>
            </form>
        </div>

        <!--FOOTER-->
        <?php include '../footer/shortfooter.php'; ?>
        <!--END FOOTER-->
    </body>

    </html>