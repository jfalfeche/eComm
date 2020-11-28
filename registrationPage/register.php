<!DOCTYPE html>
<html>

<head>
    <title>PhilCafe - Register</title>
    <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/register-style.css">
</head>

<body>
    <div id="container">

        <div class="left-login">
            <img src="../assets/img/login-bg.jpg">
        </div>

        <div class="right-login">
            <div class="return">
                <a href="../homePage/home.php" class="home">
                    <i class="far fa-arrow-alt-circle-left fa-lg"></i>&nbsp;
                    <span style="font-size: 18px;">Back to Home</span>
                </a>
            </div>

            <div class="signup-form">
                <h1>REGISTER</h1>
                <p class="hint-text">as</p>
                <div class="form-group">
                    <div class="row">
                        <form action="register_buyer.php" method="post">
                            <div class="col"><button type="submit" class="btn btn-success btn1 btn-lg btn-block">BUYER</button></div>
                        </form>
                        <form action="register_seller.php" method="post">
                            <div class="col"><button type="submit" class="btn btn-success btn2 btn-lg btn-block">SELLER</button></div>
                        </form>
                    </div>
                </div>

                <form action="../loginPage/login.php" method="post">
                    <hr class="rounded-border">
                    <div class="text-center" style="color:black; margin-top:30px; margin-bottom:20px">Already have an account?</div>
                    <div class="center"><button type="submit" class="btn btn-success btn3 btn-lg btn-block">LOGIN</button></div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>