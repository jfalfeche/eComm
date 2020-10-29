<!DOCTYPE html>
<html>

<head>
    <title>Buyer Registration</title>
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

    <div class="header">
        <div class="row">
            <a class="back" href=""><img src="../media/back1.svg" alt=""></a>
            <h5>Back to Login</h5>
        </div>
        <h2 class="text-center">Register as PhilCafe Customer</h2>
        <hr class="solid">
    </div>

    <!--REGISTRATION FORM-->
    <div class="signup-form">
        <form action="" method="post">
            <div class="form-group">
                <p>Full Name</p>
                <div class="row">
                    <div class="col"><input type="text" class="form-control" name="firstName" placeholder="First Name" required="required"></div>
                    <div class="col"><input type="text" class="form-control" name="middleName" placeholder="Middle Name" required="required"></div>
                    <div class="col"><input type="text" class="form-control" name="lastName" placeholder="Last Name" required="required"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <p>Username</p><input type="text" class="form-control" name="username" placeholder="Buyer2020" required="required">
                    </div>
                    <div class="col">
                        <p>Phone Number</p><input type="text" class="form-control" name="contactNumber" placeholder="0910*******" required="required">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <p>Delivery Address</p>
                <input type="text" class="form-control" name="permanentAddress" placeholder="House no., Street no., Barangay, City" required="required">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <p>Gender</p><label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="female">
                            <span class="form-check-label"> Female</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" value="male">
                            <span class="form-check-label"> Male </span>
                        </label>
                    </div>
                    <div class="col">
                        <p>Birthday</p><input type="date" class="form-control" name="birthday" placeholder="Phone Number" required="required">
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">
                    <div class="col">
                        <p>Email Address</p><input type="text" class="form-control" name="customerEmail" placeholder="sample_email2020@gmail.com" required="required">
                    </div>
                    <div class="col">
                        <p>Confirm Email Address</p><input type="text" class="form-control" name="customerEmail" placeholder="sample_email2020@gmail.com" required="required">
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">
                    <div class="col">
                        <p>Password</p><input type="password" class="form-control" name="password" placeholder="*minimum of 8 characters" required="required">
                    </div>
                    <div class="col">
                        <p>Confirm Password</p><input type="password" class="form-control" name="password" placeholder="*minimum of 8 characters" required="required">
                    </div>
                </div>
            </div>
        </form>
        <button type="submit" name="submit-button" class="btn btn-success btn-lg btn-block">Create Account</button>
    </div>

    <!--END OF REGFORM-->

    <!--FOOTER-->
    <?php include '../footer/shortfooter.php'; ?>
    <!--END FOOTER-->
</body>

</html>