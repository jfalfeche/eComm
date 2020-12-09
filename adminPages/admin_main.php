<?php

	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION['LGUID']))
    {
	    $servername = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname = "philcafe";
	    // Create connection
	    $conn = new mysqli($servername, $username, $password, $dbname);

	    $order = "SELECT * from `order` WHERE status>0 AND status<5 ORDER BY dateOrdered ASC";
	   	$store = "SELECT * from `sellers` WHERE storeStatus=false";

	   	//save current page url
	   	$page = $_SERVER["REQUEST_URI"];
		$_SESSION['prevUrl'] = $page;

	   	include 'admin_method.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Admin</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="../navbar/nav.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/productCard.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/admin-style.css">

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</head>
<body>
	<!--NAV-->
    <nav class="nav guest">
        <div class="col-md-2">
            <div class="logo">
                <h1>LOGO</h1>
            </div>
        </div>
        <div class="col-md-8"></div>
        <?php 
            include '../navbar/admin.php';
        ?>
    </nav>
    <!--END NAV-->

	<!--START: DELETE MODAL-->
	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModal">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">&times;</button>
                </div>
            
                <div class="modal-body">
                    <p>You are about to delete a Store Application, this procedure is irreversible.</p>
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

	<div id="container" class="d-flex flex-column">
		<div id="pending-orders" class="p-2">
			<span style="font-size: 24px; font-weight: 500;">PENDING ORDERS</span>
			<hr class="mt-1 mb-2">
			<div class="sort">
				<form name="sortFormOrder" action="admin_main.php" method="post">
					<select name="sortOrder" class="form-control" onChange="sortFormOrder.submit()">
						<option>Sort by</option>
						<option value="all">All</option>
						<option value="oldest-newest">Oldest-Newest</option>
						<option value="newest-oldest">Newest-Oldest</option>
						<option value="pending">Status: Pending</option>
						<option value="approved">Status: Approved</option>
						<option value="packed">Status: Packed</option>
						<option value="shipped">Status: Shipped</option>
					</select>
				</form>
			</div>
			<span style="font-size: 12px; font-weight: 500;"><i>click on any item to view details</i></span>

			<table id="pending-orders-table" class="table table-hover">
				<thead>
					<tr>
					    <th scope="col">ORDER #</th>
					    <th scope="col">STATUS</th>
					    <th scope="col">DATE ORDERED</th>
					    <th scope="col">BUYER</th>
					    <th scope="col">ORDER DETAILS</th>
					    <th scope="col">ORDER TOTAL</th>
				    </tr>
				</thead>
				<tbody>
					<?php
						get_order();
						$result = $conn->query($order);
		                if ($result->num_rows > 0) 
		                {
		                    // output data of each row
		                    while ($row = $result->fetch_assoc()) 
		                    {
	                ?>		
	                        <tr>
	                            <td>
	                                <?php echo sprintf('%08d', $row['orderNo']) ?>
	                            </td>
	                            <td>
	                            	<span style="color: <?php echo get_status_color($row['status']) ?>;">
	                            	<strong><?php get_status_name($row['status']); ?></strong>
	                            	</span>
	                            </td>
	                            <td>
	                                <?php echo date('d M Y', strtotime($row['dateOrdered'])) ?>
	                            </td>
	                            <td>
	                                <?php get_customer_name($row['buyerID']); ?>
	                            </td>
	                            <td>
	                                <?php get_product_details($row['buyerID'], $row['orderNo']) ?>
	                            </td>
	                            <td>
	                                <div style="text-align: right;">
	                                	PHP&emsp;<?php echo number_format($row['totalAmount'], 2, '.', ' ') ?>
	                                </div>
	                            </td>
	                            <td style="display: none;">
	                            	<a href="orderDetails.php?orderNo=<?php echo $row['orderNo']?>" class="btn btn-primary"></a>
	                            </td>
	                        </tr>
	                       
	                <?php
	                   	 }
	                	} 
	                	else echo "Database is empty";
	                	
	                ?>
				</tbody>
			</table>
		</div>

		<div id="store-applications" class="p-2">
			<span style="font-size: 24px; font-weight: 500;">STORE APPLICATIONS</span>
			<hr class="mt-1 mb-2">

			<div class="search">
				<form name="searchPendingStore" action="admin_main.php" method="post">
					<input type="text" name="searchPendingVal" class="form-control inputfld" placeholder="Search Pending Store Name here...">
					<button type="submit" name ="searchPending" class="btn btn-primary mb-2 searchbtn">SEARCH   <i class="fas fa-search"></i></button>	
				</form>
			</div>
			<?php
				if(isset($_POST['searchPending'])){
					search_pending_store($_POST['searchPendingVal']);
					unset($_POST['searchPending']);
				}
			?>
			<div class="sort">
				<form name="sortFormPendingStore" action="admin_main.php" method="post">
						<select name="sortPendingStore" class="form-control" onChange="sortFormPendingStore.submit()">
							<option>Sort by</option>
							<option value="all">All</option>
							<option value="A-to-Z">A to Z</option>
							<option value="Z-to-A">Z to A</option>
							<option value="oldest-newest">Oldest-Newest</option>
							<option value="newest-oldest">Newest-Oldest</option>
						</select>
				</form>
			</div>



			<table id="store-applications-table" class="table table-hover">
				<thead>
					<tr>
						<th scope="col">ADD</th>
					    <th scope="col">APPLICATION #</th>
					    <th scope="col">STORE NAME</th>
					    <th scope="col">DESCRIPTION</th>
					    <th scope="col">EMAIL ADDRESS</th>
					    <th scope="col">DELETE</th>
				    </tr>
				</thead>
				<tbody>
					<?php
						if(isset($_POST['sortPendingStore'])){
							get_pending_store();
							unset($_POST['sortPendingStore']);
						}

						$result = $conn->query($store);
						
		                if ($result->num_rows > 0) 
		                {
		                    // output data of each row
		                    while ($row = $result->fetch_assoc()) 
		                    {
	                ?>
	                <tr>
	                			<td>
	                				<a href="editStore.php?sellerID=<?php echo $row['sellerID'] ?>"><i class="fas fa-plus-square fa-2x"></i></a>
	                			</td>
	                            <td>
	                                <?php echo sprintf('%08d', $row['sellerID']) ?>
	                            </td>
	                            <td>
	                            	<?php echo $row['storeName'] ?>
	                            </td>
	                            <td>
	                                <?php echo substr($row['storeDescription'], 0, 200); ?>
	                            </td>
	                            <td>
	                                <?php echo $row['storeEmail']; ?>
	                            </td>
	                            <td>
	                            	
	                            		<!--<a href="deleteStore.php?sellerID=<?php //echo $row['sellerID'] ?>">-->
	                            	<button type="button" class="btn fas fa-trash-alt fa-2x" data-seller="<?php echo $row['storeName'] ?>"data-href="deleteStore.php?sellerID=<?php echo $row['sellerID'] ?>"  data-toggle="modal" data-target="#confirm-delete" id="delModal">	</button>
	                            		
	                            	
	                            </td>
	                        </tr>
	                       
	                <?php
	                   	 }
	                	} 
	                	else echo "Database is empty";
	                ?>	
				</tbody>
			</table>
		</div>

		<div id="partner-stores" class="p-2">	
			
			<?php
				include 'admin_pagination.php';
		       
			?>

		</div>
	</div>





</body>
</html>

<?php
		$conn->close();
	}

	else
		header("Location: ../loginPage/login.php");

?>

<script>
	$('#confirm-delete').on('show.bs.modal', function(e) 
	{
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');

        $('.seller-name').html('Store Name: <strong>' + $(e.relatedTarget).data('seller') + '</strong>');
    });

	//when a row is clicked, a search is done for the href belonging to an anchor. If one is found, the window’s location is set to that href
	$(document).ready(function() 
	{

	    $('#pending-orders-table tr').click(function() {
	        var href = $(this).find("a").attr("href");
	        if(href) {
	            window.location = href;
	        }
	    });
	});


	for(var k = 1; k <= <?php echo $total_pages ?>; k++)
	{
        $(document).on("click", "button#"+k+"", function(e)
        {
            e.preventDefault();
            $.get('admin_pagination.php', {pageno:this.id}
            , function(d){
                $('#partner-stores').html(d);
            });
            localStorage['currentPage'] = this.id;
        }); 
    }
</script>