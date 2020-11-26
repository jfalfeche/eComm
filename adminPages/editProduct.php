<?php
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

		function getSeller($sellerID) {
			return $sql = "SELECT * FROM product, productunit, productcategory WHERE (productunit.productUnitID = product.productUnitID) AND (productcategory.productCategoryID = product.productCategory) AND (seller=$sellerID) LIMIT 1";
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

		$sql = getSeller($sellerID);
		$result = getResult($conn,$sql);
		
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
			<form id="form-id" class="inline">
				<button type="submit" name="back-btn" id="submit-id" class="inline">
					<i class="fas fa-arrow-circle-left fa-3x inline"></i>
				</button>
			</form>

			<span style="font-size: 2em;" class="inline">ADD PRODUCT</span>
			&nbsp;&nbsp;
			<i class="fas fa-pen fa-2x inline"></i>
			<hr class="mt-1 mb-2">
		</div>

		<div id="main" class="row">
			<div class="col-8">
				<form method="post" action="editStore.php?sellerID=<?php echo $sellerID;?>" enctype="multipart/form-data" id="form-id">
					<?php
						if(mysqli_num_rows($result) == 1)
							$row = $result->fetch_assoc();
    					{
    				?>

					<label>Product Name</label>
					<input type="text" name="productName" class ="form-control" required value="<?php echo $row['productName']; ?>">
					
					<br><br>
					<label>Product Description</label>
					<textarea name="productDesc" class ="form-control" rows="7" required><?php echo $row['productDesc']; ?></textarea>

					<br><br>
					<label>Price</label>
					<input type="number" min="1" step="any" name="productPrice">
					<span>per</span>
					<select name="" id="">
						<?php
							$sql = getUnit();
							$result = getResult($conn,$sql);
							
							while ($row = $result->fetch_assoc()){
								echo "<p>".$row['name']."</p>";
								echo "<option value='". $row['productUnitID'] ."'>" .$row['name'] ."</option>" ;
							}
						?>
					</select>
					
					<br><br>
					<label>Category</label>
					<select name="" id="">
						<?php
							$sql = getCategory();
							$result = getResult($conn,$sql);
							
							while ($row = $result->fetch_assoc()){
								echo "<p>".$row['name']."</p>";
								echo "<option value='". $row['productCategoryID'] ."'>" .$row['name'] ."</option>" ;
							}
						?>
					</select>

					<br><br>
					<label>Quantity</label>
					<input type="number" min="1" name="productPrice">

			</div>

			<div class="col-4">

				<div class="imgwrap">
                    <?php
                        	echo '<img class="img-thumbnail mx-auto mx-auto d-block full-width" src="data:image/jpeg;base64,'. $row['profilePhoto'].'" alt="Store Profile Picture">';
                        }
                    ?>
                     
                </div>

                <div class="col text-center">
                	<label class="file form-control">
	                	<input type="file" name="profilePhoto" class="inputfile" >
	                    <i class="fas fa-upload form-control-file">
	                    	<span style="font-family: 'Roboto';">Upload image</span></i>
                 	<span style="font-size: 10px; font-weight: 500; width: 100%;"><br><br><i>click save changes to see if the photo was uploaded successfully</i></span>
                 	</label>

					<button type="submit" name="submit-button" class="btn btn-primary" id="submit-id">SAVE CHANGES</button>
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