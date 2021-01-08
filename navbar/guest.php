<?php  
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   
    
    // Append the requested resource location to the URL   
    $url.= $_SERVER['REQUEST_URI'];    
?>

<a class="col-md-1 <?php if(strpos($url,"home.php")) echo 'nav-active'?>" href="../homePage/home.php">Home</a>
<a class="col-md-1 <?php if(strpos($url,"about.php")) echo 'nav-active'?>" href="../homePage/about.php">About</a>
<a class="col-md-1 <?php if(strpos($url,"product.php") || strpos($url,'productDetail.php') || strpos($url,'profile_store.php')) echo 'nav-active'?>" href="../products/product.php">Products</a>
<a class="col-md-1 <?php if(strpos($url,"contact.php")) echo 'nav-active'?>" href="../phpmailer/contact.php">Contact</a>
<a class="col-md-1" href="../loginPage/login.php">Login</a>