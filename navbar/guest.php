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

<a class="col-md-1 <?php if(strpos($url,'http://localhost/eComm/homePage/home.php') == 'true') echo 'nav-active'?>" href="../homePage/home.php">Home</a>
<a class="col-md-1" href="">About</a>
<a class="col-md-1 <?php if(strpos($url,'http://localhost/eComm/products/product.php') == 'true') echo 'nav-active'?>" href="../products/product.php">Products</a>
<a class="col-md-1 <?php if(strpos($url,'http://localhost/eComm/phpmailer/contact.php') == 'true') echo 'nav-active'?>" href="../phpmailer/contact.php">Contact</a>
<a class="col-md-1" href="../loginPage/login.php">Login</a>