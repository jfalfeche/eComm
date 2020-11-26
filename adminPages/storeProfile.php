<?php
	if(isset($_GET['sellerID']))
	{

		$servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "philcafe";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

	    session_start();
	    //save current page url
	    $page = $_SERVER["REQUEST_URI"];
		$_SESSION['prevUrl'] = $page;

	    //get sellerID
	     $sellerID =  filter_var($_GET['sellerID'], FILTER_SANITIZE_NUMBER_INT);

	    $sql = "SELECT * FROM sellers WHERE sellerID=$sellerID LIMIT 1";
	    $result = $conn->query($sql);

	    include 'storeProfile_method.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Philcafe - Store Profile</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="../assets/css/productCard.css">
	<link rel="stylesheet" href="../assets/css/store-profile-style.css">
</head>
<body>

<!--START: DELETE STORE PROFILE MODAL-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModal">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">&times;</button>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete a Store Profile, this procedure is irreversible.</p>
                    <p class="seller-name"></p>
                    <p>Do you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok">Delete</a>
                </div>
            </div>
        </div>
    </div>
<!--END: DELETE MODAL-->


<!--START: DELETE PRODUCT MODAL-->
    <div class="modal modal-product fade" id="confirm-delete-product" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModal">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">&times;</button>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete a Product, this procedure is irreversible.</p>
                    <p class="product-name"></p>
                    <p>Do you want to proceed?</p>
                    <p class="product-debug-url"></p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-confirm">Delete</a>
                </div>
            </div>
        </div>
    </div>
<!--END: DELETE MODAL-->

	<div id="container">
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

				<div class="col edit-btn">
					<a href="editStore.php?sellerID=<?php echo $sellerID;?>" class="btn bg-transparent btn-primary-outline text-center" role="button">
						<i class="fas fa-pen"></i>&emsp;EDIT PROFILE
					</a>
				</div>
			</div>
		</div>

		<div id="delete-profile">
			<button type="button" class="btn  btn-outline-danger" data-seller="<?php echo $row['storeName'] ?>"data-href="deleteStore.php?sellerID=<?php echo $row['sellerID'] ?>"  data-toggle="modal" data-target="#confirm-delete" id="delModal">DELETE PROFILE</button>
		</div>

		<div id="orders">
			<span style="font-size: 32px; font-weight: 500;">ORDERS</span>
			<hr class="mt-1 mb-2">

			 <div class="row">
			    <div class="col">
			    	<a href="orderHistory.php?sellerID=<?php echo $row['sellerID'] ?>">
						<i class="fas fa-history fa-3x"></i>
						<br><br>
						<b>Order History</b>
			      	</a>
			    </div>

			    <div class="col">
			    	<a href="pendingOrders.php?sellerID=<?php echo $row['sellerID'] ?>">
						<i class="far fa-check-circle fa-3x"></i>
						<br><br>
						<b>Pending Order History</b>
					</a>
			    </div>
			  </div>

		</div>
		

		<div id="manage-products">
			<span style="font-size: 32px; font-weight: 500;">MANAGE PRODUCTS</span>
			<hr class="mt-1 mb-2">
			<div class="row">
				<div class="add-product col">
					<a href="addProduct.php?sellerID=<?php echo $row['sellerID'] ?>">
						<i class="fas fa-plus-square fa-2x"></i>
						<span style="font-size: 28px;">&nbsp;ADD PRODUCT</span>
					</a>
				</div>

				<div class="search col">
					<form name="searchProducts" action="storeProfile.php?sellerID=<?php echo $sellerID; ?>" method="post">
						<input type="text" name="searchProductsVal" class="form-control inputfld" placeholder="Search Products here...">
						<button type="submit" name ="srchProduct" class="btn btn-primary mb-2 searchbtn">SEARCH   <i class="fas fa-search"></i></button>	
					</form>
				</div>
			</div>
			<?php
				include 'storeProfile_pagination.php';
			?>
		</div>

		<?php
			}
			else
				header("Location: admin_main.php");
		?>	
	</div>

</body>
</html>

<script>
	$('#confirm-delete').on('show.bs.modal', function(e) 
	{

        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');

        $('.seller-name').html('Store Name: <strong>' + $(e.relatedTarget).data('seller') + '</strong>');
    });

</script>


<script>
    $('#confirm-delete-product').on('show.bs.modal', function(e) 
    {

        $(this).find('.btn-confirm').attr('href', $(e.relatedTarget).data('href'));
       
        $('.product-debug-url').html('Delete URL: <strong>' + $(this).find('.btn-confirm').attr('href') + '</strong>');
        
        $('.product-name').html('Product Name: <strong>' + $(e.relatedTarget).data('product') + '</strong>');
    });

</script>


<?php
	}
	
	else
		header("Location: admin_main.php");
	
?>