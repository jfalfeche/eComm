<?php
    session_start();
    $page = $_SERVER["REQUEST_URI"];
	$_SESSION['prevUrl'] = $page;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhilCafe - About Us</title>
    <!-- Bootstrap and jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Animate on Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Assets -->
    <link rel="stylesheet"	 type="text/css" href="../assets/css/contact-style.css">
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="../assets/css/about-style.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
</head>
<body>
    <script>AOS.init();</script>
    <!--NAV-->
    <nav class="nav guest fixed-top">
        <div class="col-md-3">
            <div class="logo">
                <img class="imglogo" src="../assets/img/philcafe.png" alt="">
                <h1 class="logotitle">PhilCafe</h1>
            </div>
        </div>
        <?php 
            if (isset($_SESSION['userID'])) {
        ?>
        <div class="col-md-2"></div>
        <?php 
                include '../navbar/buyer.php';
            } else {
        ?>
        <div class="col-md-4"></div>
        <?php
                include '../navbar/guest.php';}
        ?>
    </nav>
    <!--END NAV-->
    <!-- Header image -->
    <header>
        <div class="overlay"></div>
        <img src="../assets/img/about/hd1.png" alt="PhilCafe Banner">
        <div class="container h-100">
            <div class="d-flex h-100 text-center align-items-center">
                <div class="w-100 text-white">
                    <h1 class="display-3">PhilCafe</h1>
                    <p class="lead mb-0">Tagline Here</p>
                </div>
            </div>
        </div>
    </header>
    <!-- Our Story and Image -->
    <div class="row ostory" data-aos="fade-up">
        <div class="col-md-6 ostorytxt">
            <div data-aos="fade-right">
                <h1>OUR STORY</h1>
                <hr class="ostoryhr">
                <p>
                    Nunc tempus dapibus lorem in mollis. Nulla eu lacus nec ipsum ornare auctor quis sit amet nisl. Aliquam tincidunt at felis at ornare. Mauris commodo fermentum quam non porttitor. Praesent ornare neque ut gravida pretium. Integer eleifend orci et venenatis cursus. Donec bibendum viverra lectus vel lacinia. Pellentesque non lobortis diam. Mauris ac massa lobortis, sagittis felis a, tristique lorem. 
                </p>
            </div>
        </div>
        <img src="../assets/img/about/img1.png" class="col-md-6 ostoryimg" alt="" data-aos="fade-left">
    </div>
    <!-- Video Gallery -->
    <!--Carousel Wrapper-->
    <div id="gallery1" class="carousel slide carousel-fade" data-ride="carousel" data-aos="zoom-in-down">
        <!--Indicators-->
        <ol class="carousel-indicators">
            <li data-target="#gallery1" data-slide-to="0" class="active"></li>
            <li data-target="#gallery1" data-slide-to="1"></li>
            <li data-target="#gallery1" data-slide-to="2"></li>
        </ol>
        <!--/.Indicators-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <video class="video-fluid" controls data-aos="zoom-in-down">
                    <source class="g1_vid" src="../assets/img/about/vid1.mp4" type="video/mp4" />
                </video>
            </div>
            <div class="carousel-item">
                <video class="video-fluid" controls data-aos="zoom-in-down">
                    <source class="g1_vid" src="../assets/img/about/vid2.mp4" type="video/mp4" />
                </video>
            </div>
            <div class="carousel-item">
                <video class="video-fluid" controls data-aos="zoom-in-down">
                    <source class="g1_vid" src="../assets/img/about/vid3.mp4" type="video/mp4" />
                </video>
            </div>
        </div>
        <!--/.Slides-->
        <!--Controls-->
        <div class="ccontrols">
            <a id="a_prev" class="carousel-control-prev" href="#gallery1" role="button" data-slide="prev">
                <img class="thumbnail" id="t_prev" src="../assets/img/about/t3.png" alt="">
                <span class="sr-only">Previous</span>
            </a>
            <a id="a_next" class="carousel-control-next" href="#gallery1" role="button" data-slide="next">
                <img class="thumbnail" id="t_next" src="../assets/img/about/t2.png" alt="">
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!--/.Controls-->
    </div>
    <!--Carousel Wrapper-->
    <br><br>
    <!-- What we do -->
    <div class="wwd row" data-aos="fade-up">
        <div class="wwdtitle" data-aos="fade-up">
            <h1>WHAT WE DO</h1>
            <hr>
            <br><br>
        </div>
        <div class="row" data-aos="fade-up">
            <div class="col-md-4">
                <i class="fa fa-users fa-5x" data-aos="fade-up"></i><br>
                <h1 data-aos="fade-up">LOREM</h1>
                <p data-aos="fade-up">
                    Mauris iaculis odio ac euismod condimentum. Cras accumsan purus dignissim massa laoreet scelerisque. Proin sit amet auctor nulla. Donec arcu sem, cursus eget mauris sed, iaculis blandit lorem.
                </p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-briefcase fa-5x" data-aos="fade-up"></i><br>
                <h1 data-aos="fade-up">IPSUM</h1>
                <p data-aos="fade-up">
                    Mauris iaculis odio ac euismod condimentum. Cras accumsan purus dignissim massa laoreet scelerisque. Proin sit amet auctor nulla. Donec arcu sem, cursus eget mauris sed, iaculis blandit lorem.
                </p>
            </div>
            <div class="col-md-4">
                <i class="fa fa-search fa-5x" data-aos="fade-up"></i><br>
                <h1 data-aos="fade-up">DOLOR</h1>
                <p data-aos="fade-up">
                    Mauris iaculis odio ac euismod condimentum. Cras accumsan purus dignissim massa laoreet scelerisque. Proin sit amet auctor nulla. Donec arcu sem, cursus eget mauris sed, iaculis blandit lorem.
                </p>
            </div>
        </div>
    </div>
    <!-- What we do -->
    <!-- Image Gallery -->
    <div id="gallery2" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="" src="../assets/img/about/t1.png" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption Title</h5>
                    <p>Caption Paragraph</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="" src="../assets/img/about/t2.png" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                <h5>Caption Title</h5>
                    <p>Caption Paragraph</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="" src="../assets/img/about/t3.png" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Caption Title</h5>
                    <p>Caption Paragraph</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#gallery2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#gallery2" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- Image Gallery -->
    <!-- Footer -->
    <div id="contact">
        <?php include './contact.php';?>
    </div>
    <!-- JS script for control thumbnails -->
    <script>
        $('#gallery1').on('slid.bs.carousel', function () {
            link = document.querySelector('.active .video-fluid .g1_vid').src;
            if (link == "http://localhost/eComm/assets/img/about/vid1.mp4") {
                document.getElementById('t_prev').src = "http://localhost/eComm/assets/img/about/t3.png";
                document.getElementById('t_next').src = "http://localhost/eComm/assets/img/about/t2.png";
            } else if (link == "http://localhost/eComm/assets/img/about/vid2.mp4") {
                document.getElementById('t_prev').src = "http://localhost/eComm/assets/img/about/t1.png";
                document.getElementById('t_next').src = "http://localhost/eComm/assets/img/about/t3.png";
            } else if (link == "http://localhost/eComm/assets/img/about/vid3.mp4") {
                document.getElementById('t_prev').src = "http://localhost/eComm/assets/img/about/t2.png";
                document.getElementById('t_next').src = "http://localhost/eComm/assets/img/about/t1.png";
            }
        })
    </script>
</body>
</html>