<?php

/* VARIABLES */

// If you wish to show a logo in the mail, paste the URL here.
// For example: http://mywebsite.com/mylogo.png
// Remember http://
$logo_url = "";

/* VARIABLES END */

if( isset($_POST['submit']) ) {

	$name				= $_POST['name'];
	$email		  = $_POST['email'];
	$message		= $_POST['message'];
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$antispam 	= (isset($_POST['url']) && $_POST['url'] == '') ? true : false;
	
	if( $name == "" || $email == "" || $message == "" ) {
	  echo 'One or more fields has not been filled out.<br>
	  Please go back and try again.';
	
	} elseif( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
    echo 'The email address could not be validated.<br>
    Please go back and verify your email address.';
	
	} else { // All checks passed
	
    if( isset($logo_url) && strlen($logo_url) > 3 ) {
      $logo = '<img src="'.$logo_url.'" alt="" style="border:none;"><br><br>';
    } else { 
      $logo = ""; 
    }
    
    $content = '<html><head><style>body { font-family: Verdana; font-size: 12px; }</style></head><body>';
    $content .= "$logo
New mail from: Tripper Tech Web Portal<br><br>
Name: $name <br>
Email: $email <br><br>

Message:<br>".nl2br($message)."<br><br>
Regards,<br>
Team Tripper Technologies Pvt Ltd<br>
</body></html>";

	
		require 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer;
		
		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'dpareba';                 // SMTP username
		$mail->Password = 'Redsu!!79';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		
		//$mail->From = $_POST['email'];
		$mail->From = 'info@trippertech.com';
		//$mail->FromName = $_POST['name'];
		$mail->FromName = 'Tripper Tech Portal';
		$mail->addAddress('manan@tripperwifi.com');
		$mail->addAddress('dilippareba@gmail.com');
		
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = 'Contact Form sent from Tripper Tech Web Portal';
		$mail->Body    = $content;
		
		// If spam check has passed, attempt to send the mail
		if( $antispam ) {
				
			if(!$mail->send()) {
				echo '<p>An error occured and the mail could not be sent.<br>Please try again later.<br/>';
				echo '<strong>Mailer Error: ' . $mail->ErrorInfo.'</strong></p>';
			} else {
			  echo '<p>Thank you, the mail has been successfully sent!</p>';
			}
			
		// If the spam check failed, do not send mail but let spammers think it did
		} else {
			echo '<p>Thank you, the mail has been successfully sent!</p>';
		}
	}
} else {
	echo '<p>An error occured and the mail could not be sent.<br>Please try again later.</p>';
}