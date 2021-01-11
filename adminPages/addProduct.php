<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['LGUID']))
    {
		if(isset($_GET['sellerID']))
		{
			$servername = "localhost";
		    $username = "root";
		    $password = "";
		    $dbname = "philcafe";
		    // Create connection
		    $conn = new mysqli($servername, $username, $password, $dbname);

			//get sellerID
			$sellerID =  $_GET['sellerID'];

			function getUnit() {
				return $sql = "SELECT * FROM  productunit";
			}
		
			function getCategory() {
				return $sql = "SELECT * FROM productcategory";
			}
			
			function getResult($conn,$sql) {
				return $result = $conn->query($sql);
			}

			include 'addProduct_method.php';

			$page = $_SERVER["REQUEST_URI"];
		
			//save previous currentUrl as previousUrl
		   	if($page != $_SESSION['currentUrl'])
		   		$_SESSION['prevUrl'] = $_SESSION['currentUrl'];

			// save current url as currentUrl
			$_SESSION['currentUrl'] = $page;
?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Add Product</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/edit-store-style.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/editProduct.css">
    <link rel="stylesheet" href="../navbar/nav.css">
	
</head>
<body>

	<!--NAV-->
    <nav class="nav guest">
        <div class="col-md-3">
            <div class="logo">
				<img class="imglogo" src="../assets/img/philcafe.png" alt="">
                <h1 class="logotitle">PhilCafe</h1>
            </div>
        </div>
        <div class="col-md-7"></div>
        <?php 
            include '../navbar/admin.php';
        ?>
    </nav>
    <!--END NAV-->

	<div id="container">
		<div id="title">
			<a href="storeProfile.php?sellerID=<?php echo $sellerID;?>" class="text-decoration-none" >
				<i class="fas fa-arrow-circle-left fa-3x inline"></i>
			</a>
			<span style="font-size: 2em;" class="inline">ADD PRODUCT</span>
			&nbsp;&nbsp;
			<i class="fas fa-pen fa-2x inline"></i>
			<hr class="mt-1 mb-2">
		</div>

		<div id="main" class="row">
			<div class="col-8">
				<form method="post" action="addProduct.php?sellerID=<?php echo $sellerID;?>" enctype="multipart/form-data" id="form-id" runat="server">
					<label>Product Name</label>
					<input type="text" name="productName" class ="form-control" required value="">
					
					<br><br>
					<label>Product Description</label>
					<textarea name="productDesc" class ="form-control" rows="7" required></textarea>

					<br><br>
					<label>Price</label>
					<input class ="price" type="number" min="1" step="any" name="productPrice" required>
					<span>per</span>
					<select class="dropdown" name="productUnit" id="">
						<?php
							$sql = getUnit();
							$result = getResult($conn,$sql);
							
							while ($row = $result->fetch_assoc()){
								echo "<option value='". intval($row['productUnitID']) ."'>" .$row['name'] ."</option>" ;
							}
						?>
					</select>
					
					<br><br>
					<label>Category</label>
					<select class="dropdown" name="productCategory" id="">
						<?php
							$sql = getCategory();
							$result = getResult($conn,$sql);
							
							while ($row = $result->fetch_assoc()){
								echo "<option value='". intval($row['productCategoryID']) ."'>" .$row['name'] ."</option>" ;
							}
						?>
					</select>

					<br><br>
					<label>Quantity</label>
					<div class="def-number-input number-input safari_only">
						<button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
						<input id="q" class="quantity" type="number" min="1" name="quantity" value="1">
						<button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
					</div>

			</div>

			<div class="col-4">

				<div class="imgwrap">
					<img id="pimg" class="img-thumbnail mx-auto mx-auto d-block full-width" src="#" alt="Store Profile Picture">
                </div>

                <div class="col text-center">
                	<label class="file form-control">
	                	<input id="imgInp" type="file" name="productPhoto" class="inputfile" >
	                    <i class="fas fa-upload form-control-file">
	                    	<span style="font-family: 'Roboto';">Upload image</span></i>
                 	<span style="font-size: 10px; font-weight: 500; width: 100%;"><br><br><i></i></span>
                 	</label>

					<button type="submit" name="submit-button" class="btn btn-primary" id="submit-id">ADD PRODUCT</button>
				</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	window.addEventListener("DOMContentLoaded", function () 
	{
		var form = document.getElementById("form-id");

		document.getElementById("submit-id").addEventListener("click", function () {
		  form.submit();
		});
	});

	var buttons = document.querySelectorAll('form button:not([type="submit"])');
		for (i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener('click', function(e) {
			e.preventDefault();
		});
	}

	function readURL(input) {
		if (input.files && input.files[0]) {
			var file = input.files[0];
			if(parseInt(file.size) > 1500000) {
				alert("File image too large. Please upload less than 1.5MB image.");
			} else {
				var reader = new FileReader();
			
				reader.onload = function(e) {
					$('#pimg').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]); // convert to base64 string
			}
		}
	}

	$("#imgInp").change(function() {
		readURL(this);
	});

	var quant = document.getElementById("q");
	quant.addEventListener('keyup', function() {
		if (quant.value < 1)
			quant.value = 1;
	})
</script>


<?php

		}

		else
			header("Location: admin_main.php");
	}
	
	else
		header("Location: ../loginPage/login.php");
 ?>