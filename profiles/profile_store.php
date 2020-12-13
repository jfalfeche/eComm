<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
		$page = $_SERVER["REQUEST_URI"];
		$_SESSION['prevUrl'] = $page;
	}
	
	if(isset($_GET['sellerID'])) {

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "philcafe";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		//save current page url
		$page = $_SERVER["REQUEST_URI"];
		$_SESSION['prevUrl'] = $page;

		//get sellerID
		$sellerID =  filter_var($_GET['sellerID'], FILTER_SANITIZE_NUMBER_INT);

		$sql = "SELECT * FROM sellers WHERE sellerID=$sellerID LIMIT 1";
		$result = $conn->query($sql);

		include '../adminPages/storeProfile_method.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Philcafe - Store Profile</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	
    <link rel="stylesheet" href="../navbar/nav.css">
	<link rel="stylesheet" href="../footer/footer.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/productCard.css">
	<link rel="stylesheet" href="../assets/css/store-profile-style.css">
</head>
<body>
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

	<div id="container" style="margin-top:5%;">
		<?php
			if(mysqli_num_rows($result) == 1)
    		{
				$row = $result->fetch_assoc();
		?>
		<div id="banner">
			<div class="details row">
				<div class="col image">
					<br>	
					<?php
                        echo '<img class="img-thumbnail rounded img-fluid center-block" src="data:image/jpeg;base64,'. $row['profilePhoto'].'" alt="Store Profile Picture">'; 
                    ?>
				</div>

				<div class="col-5">
					<span style="font-size: 3.5em;">
						<?php echo $row['storeName'];?>
					</span><br>	

					<span style="font-size: 1.5em; font-style: italic;">
						<?php echo $row['storeEmail'];?>
					</span><br><br>	

					<span style="font-size: 1.25em;">
						<?php echo $row['storeDescription'];?>
					</span>
				</div>
			</div>
		</div>
		

		<div id="manage-products">
			<span style="font-size: 32px; font-weight: 500;">STORE PRODUCTS</span>
			<hr class="mt-1 mb-2">
			<div class="row">
				<div class="add-product col">
				</div>

				<div class="search col">
					<form name="searchProducts" action="profile_store.php?sellerID=<?php echo $sellerID; ?>" method="post">
						<input type="text" name="searchProductsVal" class="form-control inputfld" placeholder="Search Products here...">
						<button type="submit" name ="srchProduct" class="btn btn-primary mb-2 searchbtn">SEARCH   <i class="fas fa-search"></i></button>	
					</form>
				</div>
			</div>
			<?php
				include './profile_store_pagination.php';
			?>
		</div>

		<?php
			}
		?>	
	</div>
	<?php include '../footer/longfooter.php';?>
</body>
</html>
<?php
	}
?>