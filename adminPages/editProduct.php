<?php
	session_start();
	if(isset($_GET['productID']))
	{
		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "philcafe";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

		//get sellerID
		$productID =  $_GET['productID'];

		function getSeller($productID) {
			return $sql = "SELECT * FROM product, productunit, productcategory WHERE (productunit.productUnitID = product.productUnitID) AND (productcategory.productCategoryID = product.productCategory) AND product.productID = $productID";
		}

		function getUnit() {
			return $sql = "SELECT * FROM  productunit";
		}
	
		function getCategory() {
			return $sql = "SELECT * FROM productcategory";
		}
		
		function getResult($conn,$sql) {
			return $result = $conn->query($sql);
		}

		$sql = getSeller($productID);
		$result = getResult($conn,$sql);
		
		include 'editProduct_method.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Edit Product</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/edit-store-style.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/editProduct.css">
</head>
<body>
	<div id="container">
		<div id="title">
			<a href="<?php echo $_SESSION['prevUrl'];?>" class="text-decoration-none" >
				<i class="fas fa-arrow-circle-left fa-3x inline"></i>
			</a>
			<span style="font-size: 2em;" class="inline">EDIT PRODUCT</span>
			&nbsp;&nbsp;
			<i class="fas fa-pen fa-2x inline"></i>
			<hr class="mt-1 mb-2">
		</div>

		<div id="main" class="row">
			<div class="col-8">
				<form method="post" action="editProduct.php?productID=<?php echo $productID;?>" enctype="multipart/form-data" id="form-id">
					<?php
						if(mysqli_num_rows($result) == 1)
							$row = $result->fetch_assoc();
    					{
    				?>

					<label>Product Name</label>
					<input type="text" name="productName" class ="form-control" required value="<?php echo $row['productName']; ?>">
					
					<br><br>
					<label>Product Description</label>
					<textarea name="productDesc" class ="form-control" rows="7" required><?php echo $row['description']; ?></textarea>

					<br><br>
					<label>Price</label>
					<input class ="price" type="number" min="1" step="any" name="productPrice" value="<?php echo $row['price']; ?>">
					<span>per</span>
					<select class="dropdown" name="productUnit" value="<?php echo $row['productUnitID']; ?>">
						<?php
							$sql = getUnit();
							$result = getResult($conn,$sql);
							
							while ($row = $result->fetch_assoc()){
								echo "<option value='". $row['productUnitID'] ."'>" .$row['name'] ."</option>" ;
							}
						?>
					</select>
					
					<br><br>
					<label>Category</label>
					<select class="dropdown" name="productCategory" id="" value="<?php echo $row['productCategory']; ?>">
						<?php
							$sql = getCategory();
							$result = getResult($conn,$sql);
							
							while ($row = $result->fetch_assoc()){
								echo "<option value='". $row['productCategoryID'] ."'>" .$row['name'] ."</option>" ;
							}
						?>
					</select>

					<br><br>
					<label>Quantity</label>
					<?php 
						$sql = getSeller($productID);
						$result = getResult($conn,$sql);
						$row = $result->fetch_assoc();
					?>
					<div class="def-number-input number-input">
						<button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
						<input id="q" class="quantity" min="1" name="quantity" value="<?php echo $row['stock']; ?>" type="number">
						<button onclick="this.parentNode.querySelector('#q').stepUp()" class="plus"></button>
					</div>

			</div>

			<div class="col-4">

				<div class="imgwrap">
                    <?php
                        	echo '<img id="pimg" class="img-thumbnail mx-auto mx-auto d-block full-width" src="data:image/jpeg;base64,'. $row['image'].'" alt="Store Profile Picture">';
                        }
                    ?>
                     
                </div>

                <div class="col text-center">
                	<label class="file form-control">
	                	<input id="imgInp" type="file" name="productPhoto" class="inputfile" >
	                    <i class="fas fa-upload form-control-file">
	                    	<span style="font-family: 'Roboto';">Upload image</span></i>
                 	<span style="font-size: 10px; font-weight: 500; width: 100%;"><br><br><i></i></span>
                 	</label>

					<button type="submit" name="submit-button" class="btn btn-primary" id="submit-id">UPDATE PRODUCT</button>
				</form>
				</div>
			</div>



		</div>
	</div>
</body>
</html>

<script>
	window.addEventListener("DOMContentLoaded", function () {
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
			var reader = new FileReader();
			
			reader.onload = function(e) {
			$('#pimg').attr('src', e.target.result);
			}
			
			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	$("#imgInp").change(function() {
		readURL(this);
	});
</script>


<?php

	}

	else
		header("Location: admin_main.php");
 ?>