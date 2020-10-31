<?php
    $cat = 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="../navbar/nav.css">
        <link rel="stylesheet" href="../footer/footer.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    </head>
    <body>
        <script>AOS.init();</script>
        <header>
            <div class="overlay"></div>
            <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
                <source src="./media/header.mp4" type="video/mp4">
            </video>
            <div class="container h-100">
                <div class="d-flex h-100 text-center align-items-center">
                    <div class="w-100 text-white">
                        <h1 class="display-3">PhilCafe</h1>
                        <p class="lead mb-0">Quality Products Picked Specially for You</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- NAV BAR GUEST STARTS HERE -->
        <nav class="nav guest">
            <div class="col-md-3">
                <div class="logo"><h1>LOGO</h1></div>
            </div>
            <div class="col-md-4"></div>
                <?php include '../navbar/guest.php' ?>
        </nav>
        <!-- NAV BAR GUEST ENDS HERE -->
          
        <section class="my-5">
            <div class="container text-center align-items-center">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <h2 id="products"><a href="#products">PRODUCTS</a></h2>
                        <hr>
                    </div>
                </div>

                <div data-aos="fade-up" class="row">
                    <a class="col category category-active" href="#products" id="0">ALL CATEGORIES</a>
                    <a class="col category" href="#products" id="1">FRUITS</a>
                    <a class="col category" href="#products" id="2">VEGETABLES</a>
                    <a class="col category" href="#products" id="3">ROOT CROPS</a>
                    <a class="col category" href="#products" id="4">OTHERS</a>
                </div>

                <!-- jQuery for sorting and category highlighting -->
                <script>
                    for(var i = 0; i < 5; i++){
                        $("a#"+i).on('click', function(){
                            for(j = 0; j < 5; j++){
                                $("a#"+j).removeClass('category-active');
                            }
                            $(this).addClass('category-active');
                            $.get('homeSort.php', {id:this.id}, function(d){
                                $('#display').html(d);
                            });
                        }); 
                    }
                    
                </script>
                <!-- jQuery END -->
                
                <div data-aos="fade-up" id="display">
                    <?php include 'homeSort.php' ?>
                </div>
                
            </div>
        </section>
        
        <?php include '../footer/longfooter.php';?>
    </body>
</html>