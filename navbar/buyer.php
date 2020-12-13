<?php
if(isset($_GET['logout']) && ($_GET['logout'] == true)){
    unset($_SESSION['userID']);
    unset($_SESSION['user_type']);
    header("Refresh:0");
}

if(isset($_SESSION['productDetail'])) {
    $unset($_SESSION['productDetail']);
}

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
// Append the host(domain name, ip) to the URL.   
$url .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL   
$url .= $_SERVER['REQUEST_URI'];
?>

<a class="col-md-1 <?php if (strpos($url, 'http://localhost/eComm/homePage/home.php') == 'true') echo 'nav-active' ?>" href="../homePage/home.php">Home</a>
<a class="col-md-1 <?php if(strpos($url,'http://localhost/eComm/homePage/about.php') == 'true') echo 'nav-active'?>" href="../homePage/about.php">About</a>
<a class="col-md-1 <?php if (strpos($url, 'http://localhost/eComm/products/product.php') == 'true') echo 'nav-active' ?>" href="../products/product.php">Products</a>
<a class="col-md-1 <?php if (strpos($url, 'http://localhost/eComm/phpmailer/contact.php') == 'true') echo 'nav-active' ?>" href="../phpmailer/contact.php">Contact</a>
<a class="col-md-1 <?php if (strpos($url, 'http://localhost/eComm/cart/cart.php') == 'true') echo 'nav-active' ?>" href="../cart/cart.php">My Cart</a>
<a class="col-md-1 <?php if (strpos($url, 'http://localhost/eComm/profiles/profile_buyer.php') == 'true') echo 'nav-active' ?>" href="../profiles/profile_buyer.php">My Profile</a>
<a class="col-md-1"
<?php 
    if (strpos($url, 'http://localhost/eComm/products/productDetail.php') == 'true') {
        echo "href=\"../homePage/home.php";
    } else if (strpos($url, 'http://localhost/eComm/profiles/profile_store.php') == 'true') {
        echo "href=\"../homePage/home.php";
    }
    else
        echo "href=\"".$url."";
?>?logout=true" id="logout">Logout</a>