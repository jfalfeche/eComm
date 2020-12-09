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

    	if (isset($_GET['pageno'])) 
    	{
            $pageno = intval($_GET['pageno']);
        } 
        else 
        {
            if(isset($pageno))
                {} 
            else
                $pageno = 1;
        }



	$no_of_records_per_page = 8;
	$offset = ($pageno-1) * $no_of_records_per_page;

	$total_pages_sql = "SELECT COUNT(*) FROM `sellers` WHERE storeStatus=true";

	$result = mysqli_query($conn,$total_pages_sql);
	$total_rows = mysqli_fetch_array($result)[0];
	$total_pages = ceil(($total_rows / $no_of_records_per_page));

	$partner_stores = "SELECT * FROM `sellers` WHERE storeStatus=true LIMIT $offset, $no_of_records_per_page";

	if(isset($_POST['sortStore']))
		get_store();

	if(isset($_POST['searchPartner'])){
		search_partner_stores($_POST['searchPartnerVal']);
		unset($_POST['searchPartner']);
	}
		
	$result_stores = mysqli_query($conn, $partner_stores);

?>
<span style="font-size: 24px; font-weight: 500;">PARTNER STORES</span>
<hr class="mt-1 mb-2">

<div class="search">
	<form name="searchPartnerStore" action="admin_main.php" method="post">
		<input type="text" name="searchPartnerVal" class="form-control inputfld" placeholder="Search Partner Store Name here...">
		<button type="submit" name ="searchPartner" class="btn btn-primary mb-2 searchbtn">SEARCH   <i class="fas fa-search"></i></button>
	</form>
</div>

 <div class="sort">
	<form name="sortFormStore" action="admin_main.php" method="post">
			<select name="sortStore" class="form-control" onChange="sortFormStore.submit()">
				<option>Sort by</option>
                <option value="all">All</option>
                <option value="A-to-Z">A to Z</option>
                <option value="Z-to-A">Z to A</option>
				<option value="oldest-newest">Oldest-Newest</option>
				<option value="newest-oldest">Newest-Oldest</option>
			</select>
	</form>
</div>


<div class="pageNumbers">
    <button id="1" type="button" class="btn btn-outline-dark">First</button>
    <button id="<?php if($pageno <= 1){ echo '#'; } else { echo ($pageno - 1); } ?>" type="button" class="btn btn-outline-dark"><</button>
    <?php
        for($p = 1; $p <= $total_pages; $p++){ ?>
            <button id="<?php echo $p; ?>" type="button" class="<?php if($p == $pageno) echo 'btn-active'; ?> btn btn-outline-dark"><?php echo $p ?></button>
    <?php        } ?>
    <button id="<?php if($pageno >= $total_pages){ echo '#'; } else { echo ($pageno + 1); } ?>" type="button" class="btn btn-outline-dark">></button>
    <button id="<?php echo $total_pages; ?>" type="button" class="btn btn-outline-dark">Last</button>
</div>
<!-- PAGE NUMBERS END -->

<?php 
	if ($result->num_rows > 0) 
    {
            $i = 1;
            while($row = mysqli_fetch_array($result_stores)){
                if ($i == 1 || $i % 5 == 0){
                    echo '<div class="row stores">';
                }
            ?>

            <a href="storeProfile.php?sellerID=<?php echo $row['sellerID']?>" class="text-reset text-decoration-none">
                <div class="col-md-2 card">
                    <div class="imgwrap">
                        <?php
                            echo '<img class="card-img-top img-responsive full-width" src="data:image/jpeg;base64,'.$row['profilePhoto'].'" alt="Card image cap">';
                        ?>
                    </div>
                    <div class="card-body text-left">
                        <h4 class="card-title"><?php echo $row["storeName"]; ?></h4>
                        <a href="storeProfile.php?sellerID=<?php echo $row['sellerID'];?>" class="btn btn-primary">
                            <h5 class="card-text">View Profile</h5>
                        </a>
                    </div>
                </div>
            </a>
<?php
                if ($i % 4 == 0 && $i != 0) {
                    echo '</div>';
                    $i = 0;
                }
                $i++;
            
        	} 
        }else {
            echo "<span style=\"color: red;\">No partner stores found.</span>";
        }
    }
    else
        header("Location: ../loginPage/login.php");
?>
	
	

