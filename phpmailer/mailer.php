<?php
	// Import PHPMailer classes into the global namespace
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require 'vendor/autoload.php';

	# if the submit-button is clicked
	if(isset($_POST['submit-button']) && !isset($_['trap']))
	{
		$name = filter_var($_POST['name-sender'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email-sender'], FILTER_SANITIZE_STRING);
		$phone_num = filter_var($_POST['phone-num-sender'], FILTER_SANITIZE_STRING);
		$message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
		
		// input validation
		if(empty($name))
		{
			header("Location:contact.php?no-user");
			exit();
		}

		if(empty($email) && empty($phone_num))
		{
			header("Location:contact.php?no-email-no-phone-num");
			exit();
		}

		if(empty($message))
		{
			header("Location:contact.php?no-message");
			exit();
		}

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try 
		{
			
		    //Server settings
		    $mail->SMTPDebug = 0;                      // Enable verbose debug output --- change to 2 if debugging code
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = '3349ff37ccddb9';                     // SMTP username
		    $mail->Password   = '883081d02cf890';                               // SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		    $mail->SMTPSecure = false;
		    $mail->SMTPAutoTLS = false;
			$mail->SMTPOptions = array(
	    	'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    		)
			);

		    //Sender
		    $mail->setFrom($email, $name);

		    //Recipient
		    $mail->addAddress('deusvultdegurechaff+sample@gmail.com', 'Deus Vult');     

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'PhilCafe Inquiry from '.$name;

		    //Mail content
		    $body = "<p><strong>Hello! </strong><br>
		    You have received an inquiry from: <br>
		    Name: ". $name . "
		    <br>Email: ". $email. "
		    <br>Contact Number:". $phone_num."
		    <br>The message is: <br>
		    ". $message."</p>";

		    $mail->Body    = $body;
		    $mail->AltBody = strip_tags($body);

		    $mail->send();
		    

		    header("Location: contact.php?sent");
		} 
		
		catch (Exception $e) 
		{
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}

	//header("Location: contact.php");

?>