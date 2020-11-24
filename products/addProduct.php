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

	    $sql = "SELECT * FROM sellers WHERE sellerID=$sellerID LIMIT 1";
	    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Edit Store</title>
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

			<span style="font-size: 2em;" class="inline">EDIT STORE PROFILE</span>
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

					<label>Store Name</label>
					<input type="text" name="storeName" class ="form-control" required value="<?php echo $row['storeName']; ?>">
					
					<br><br>
					<label>Email Address</label>
					<input type="email" name="storeEmail" class ="form-control" required value="<?php echo $row['storeEmail']; ?>">
					
					<br><br>
					<label>Store Description</label>
					<textarea name="storeDescription" class ="form-control" rows="7" required><?php echo $row['storeDescription']; ?></textarea>

					<?php
						if(!$row['storeStatus'])
							$storeStatus = false;
						else
							$storeStatus = true;
					?>
				
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