<?php
	session_start();
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
?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Add Product</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/edit-store-style.css">
</head>
<body>
	<div id="container">
		<div id="title">
			<a href="<?php echo $_SESSION['prevUrl'];?>" class="text-decoration-none" >
				<i class="fas fa-arrow-circle-left fa-3x inline"></i>
			</a>
			<span style="font-size: 2em;" class="inline">ADD PRODUCT</span>
			&nbsp;&nbsp;
			<i class="fas fa-pen fa-2x inline"></i>
			<hr class="mt-1 mb-2">
		</div>

		<div id="main" class="row">
			<div class="col-8">
				<form method="post" action="addProduct.php?sellerID=<?php echo $sellerID;?>" enctype="multipart/form-data" id="form-id">
					<label>Product Name</label>
					<input type="text" name="productName" class ="form-control" required value="">
					
					<br><br>
					<label>Product Description</label>
					<textarea name="productDesc" class ="form-control" rows="7" required></textarea>

					<br><br>
					<label>Price</label>
					<input type="number" min="1" step="any" name="productPrice" required>
					<span>per</span>
					<select name="productUnit" id="">
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
					<select name="productCategory" id="">
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
					<input type="number" min="1" step="1" name="quantity">

			</div>

			<div class="col-4">

				<div class="imgwrap">
                    <?php
                        	echo '<img class="img-thumbnail mx-auto mx-auto d-block full-width" src="" alt="Store Profile Picture">';
                    ?>
                     
                </div>

                <div class="col text-center">
                	<label class="file form-control">
	                	<input type="file" name="productPhoto" class="inputfile" >
	                    <i class="fas fa-upload form-control-file">
	                    	<span style="font-family: 'Roboto';">Upload image</span></i>
                 	<span style="font-size: 10px; font-weight: 500; width: 100%;"><br><br><i>click save changes to see if the photo was uploaded successfully</i></span>
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
</script>


<?php

	}

	else
		header("Location: admin_main.php");
 ?>