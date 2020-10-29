</!DOCTYPE html>
<html>
<head>
	<title>PhilCafe - Contact Us</title>
	<script src="https://kit.fontawesome.com/58872a6613.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet"	 type="text/css" href="../assets/css/contact-style.css">
	<link rel="stylesheet" href="../navbar/nav.css">
</head>
<body>
	<!--NAV-->
    <nav class="nav guest">
        <div class="col-md-1">
            <div class="logo"><h1>LOGO</h1></div>
        </div>
        <div class="col-md-6"></div>
            <?php include '../navbar/guest.php' ?>
    </nav>
    <!--END NAV-->

	<div id="container">
		<div id="left-contact">
			<h1>CONTACT US</h1>
			<hr class="rounded-border-green">
			<p>
				<h3>Philippine Agricultural Office</h3>
				<i>0936 396 1890</i><br><br>
				<i>1st Floor, Provincial Capitol Building,<br>
					Cagayan De Oro City,<br>
					Misamis Oriental 9000, Philippines<br>
				</i>
			</p>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d246.63438711447057!2d124.64844805516454!3d8.48477355345122!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32fff2d90a528e4b%3A0xe0e875d18e2957ac!2sMisamis%20Oriental%20Provincial%20Capitol!5e0!3m2!1sen!2sph!4v1603911562244!5m2!1sen!2sph" width="750" height="350" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
		
		<div id="right-contact">
			<div class="socmed-bar">
				<a href="#" class="twitter"><i class="fab fa-twitter fa-3x"></i></a> 
				<a href="#" class="facebook"><i class="fab fa-facebook fa-3x"></i></a> 
				<a href="#" class="facebook-messenger"><i class="fab fa-facebook-messenger fa-3x"></i></a> 
				<hr class="rounded-border"><br>
			</div>

			<div id="message-form">
					<br><p><strong>Leave a message</strong></p>
				<form method="post" action="mailer.php">

					<p>Full Name:</p>
					<input type="text" name="name-sender" class="form-control" placeholder="Full Name" required><br>

					<p>Email Address:</p>
					<input type="email" name="email-sender"  class="form-control" placeholder="Email Address" required><br>

					<p>Contact Number:</p>
					<input type="tel" name="phone-num-sender"  class="form-control" rows="3" placeholder="Contact Number" required><br>

					<p>Message:</p>
					<textarea name="message" class="form-control" placeholder="Your Message..." rows="7" required></textarea>
					<input type="hidden" name="trap">
					<button type="submit" name="submit-button" class="btn btn-success">SEND</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>