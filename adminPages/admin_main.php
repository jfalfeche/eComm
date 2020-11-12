<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "philcafe";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $order = "SELECT * from `order` WHERE status>0 AND status<5 ORDER BY dateOrdered ASC";
   	$store = "SELECT * from `sellers` WHERE storeStatus=false";

   include 'admin_method.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Admin</title>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../assets/css/productCard.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/admin-style.css">


</head>
<body>
	<div id="container" class="d-flex flex-column">
		<div id="pending-orders" class="p-2">
			<span style="font-size: 24px; font-weight: 500;">PENDING ORDERS</span>
			<hr class="mt-1 mb-2">
			<div class="sort">
				<form name="sortFormOrder" action="admin_main.php" method="post">
					<select name="sortOrder" class="form-control" onChange="sortFormOrder.submit()">
						<option>Sort by</option>
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
	                                <?php echo $row['dateOrdered'] ?>
	                            </td>
	                            <td>
	                                <?php get_customer_name($row['buyerID']); ?>
	                            </td>
	                            <td>
	                                <?php get_product_details($row['buyerID'], $row['orderNo']) ?>
	                            </td>
	                            <td>
	                                
	                                <div style="text-align: right;">
	                                	<?php echo $row['totalAmount'] ?>	
	                                	</div>
	                            </td>
	                            <td>
	                            	<a href="orderDetails.php?orderNo=<?php echo $row['orderNo']?>" class="btn btn-primary" style="display: none;"></a>
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
	                            	<a href="deleteStore.php?sellerID=<?php echo $row['sellerID'] ?>"><i class="fas fa-trash-alt fa-2x"></i></a>
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
			
			<!--insert search bar here-->

			


			<?php
				include 'admin_pagination.php';
		       
			?>

		</div>
	</div>
	
</body>
</html>

<?php
	$conn->close();
?>
<script>
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