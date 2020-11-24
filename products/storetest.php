<?php
	if(isset($_GET['action']))
	{
		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "philcafe";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

	    //get sellerID
        $sellerID =  $_GET['action'];
        
        $sql = "SELECT * FROM sellers WHERE sellerID=$sellerID LIMIT 1";
        $result = $conn->query($sql);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method = "post" action="addProduct.php?sellerID=<?php echo $sellerID;?>" enctype="multipart/form-data" id="form-id">
        <button type="submit">Add Product</button>
    </form>
</body>
</html>