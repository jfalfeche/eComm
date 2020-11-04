<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="icon" href="">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="../assets/css/productCard.css">
    <link rel="stylesheet" href="../navbar/nav.css">
    <link rel="stylesheet" href="../footer/footer.css">
    <link rel="stylesheet" href="product.css">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>
    <!--NAV-->
    <nav class="nav guest fixed-top">
        <div class="col-md-2">
            <div class="logo">
                <h1>LOGO</h1>
            </div>
        </div>
        <div class="col-md-5"></div>
        <?php include '../navbar/guest.php' ?>
    </nav>
    <!--END NAV-->

    <header class="row">
        <div class="col d-flex justify-content-center my-auto">
            <div class="input-group">
                <input id="searchFor" type="text" class="form-control" placeholder="Search products here..." aria-label="" aria-describedby="basic-addon1">
                <div class="input-group-append">
                    <button id="search" class="btn btn-success" type="button">Search <i class="fas fa-search"></i> </button>
                </div>
            </div>
        </div>
    </header>

    <!-- jQuery for search -->
    <script>
        $("#search").on('click', function(e){
            e.preventDefault();
            s = document.getElementById("searchFor").value;
            if(s.length > 2){
                $.get('productSort.php', {id:localStorage['currentCat'], pageno:1, search:s}, function(d){
                    $('#display').html(d);
                });
            }
            else
                alert("Enter more than 2 letters.");
        });
    </script>
    <!-- jQuery search ends here -->

    <div class="mainContent">
        <div class="row">
            <div class="col-md-4" id="categories">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <a class="text-decoration-none" href="#" id="0"><div class="category">ALL CATEGORIES</div></a>
                        <a class="text-decoration-none" href="#" id="1"><div class="category">FRUITS</div></a>
                        <a class="text-decoration-none" href="#" id="2"><div class="category">VEGETABLES</div></a>
                        <a class="text-decoration-none" href="#" id="3"><div class="category">ROOT CROPS</div></a>
                        <a class="text-decoration-none" href="#" id="4"><div class="category">OTHERS</div></a>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>

            <div class="col-md-8" id="products">
                <div class="col-md-12">
                    <h2 id="products">PRODUCTS</h2>
                    <hr>
                </div>
                <div id="display">
                    <!-- Initial display -->
                    <?php include './productSort.php' ?>

                    <!-- jQuery for page refresh -->
                    <script>
                        // if a previous category was selected
                        if(localStorage['currentCat'])
                            $("a#"+localStorage['currentCat']).addClass('category-active');
                        else
                        // if no category was formerly selected
                            $("a#0").addClass('category-active');
                            
                        // if a previous category and page was selected
                        if(localStorage['currentPage'])
                            $.get('productSort.php', {id:localStorage['currentCat'], pageno:localStorage['currentPage']}, function(d){
                                $('#display').html(d);
                            });
                        else {
                            // if no category was formerly selected
                            $.get('productSort.php', {id:0, pageno:1}, function(d){
                                $('#display').html(d);
                            });
                            localStorage['currentCat'] = 0;
                            localStorage['currentPage'] = 1;
                        }
                    </script>
                    <!-- jQuery END -->
                </div>
            </div>

            <!-- jQuery for category filter and category highlighting -->
            <script>
                for(var i = 0; i < 5; i++){
                    $("a#"+i).on('click', function(e){
                        e.preventDefault();
                        for(var j = 0; j < 5; j++){
                            $("a#"+j).removeClass('category-active');
                        }
                        $(this).addClass('category-active');
                        $.get('productSort.php', {id:this.id, pageno:1}, function(d){
                            $('#display').html(d);
                        });
                        localStorage['currentCat'] = this.id;
                        localStorage['currentPage'] = 1;
                    }); 
                }
                
            </script>
            <!-- jQuery END -->

            <!-- jQuery for pagination -->
            <script>
                for(var k = 1; k <= <?php echo $total_pages ?>; k++){
                    $(document).on("click", "button#"+k+"", function(e){
                        e.preventDefault();
                        $.get('productSort.php', {pageno:this.id, id:localStorage['currentCat']}
                        , function(d){
                            $('#display').html(d);
                        });
                        localStorage['currentPage'] = this.id;
                    }); 
                }  
            </script>
            <!-- jQuery END -->

        </div>
    </div>
    <br><br><br>
    <?php include '../footer/longfooter.php';?>
</body>
</html>