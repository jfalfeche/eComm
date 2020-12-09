<?php
if(isset($_GET['logout']) && ($_GET['logout'] == true))
{
    unset($_SESSION['LGUID']);
    $_SESSION = array();
    session_unset();
    session_destroy();
    header("Refresh:0");
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

<a class="col-md-1 
    <?php if (strpos($url, 'http://http://localhost/ecomm/adminPages/admin_main.php') == 'true') 
        echo 'nav-active' ?>" href="../adminPages/admin_main.php">
    Admin
</a>

<a class="col-md-1"
<?php 
    if (count($_GET)) {
        echo "href='$url&logout=true'";
    }
    else{
    	echo "href='$url?logout=true'";
    }
        
?>
id="logout">Logout</a>