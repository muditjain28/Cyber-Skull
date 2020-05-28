<?php

require 'connection.php';
//Include required PHPMailer files
	require 'includes/PHPMailer.php';
	require 'includes/SMTP.php';
	require 'includes/Exception.php';
//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
$conn = Connect();
$email = $conn->real_escape_string($_POST['email']);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $emailErr = "Invalid email format";
   header('Location: index.html');
}
else{
$check=mysqli_query($conn,"select * from register where email = '$email' ");
    $checkrows=mysqli_num_rows($check);
if($checkrows>0) {
      header('Location: register.html');
   }
   else { 
$query = "INSERT INTO register(email) VALUES('$email')";

      $result = mysqli_query($conn, $query);
      $success = $conn->query($result);
$mail = new PHPMailer();
//Set mailer to use smtp
	$mail->isSMTP();
//Define smtp host
	
	$mail->Host = "smtp.gmail.com";
//Enable smtp authentication
	$mail->SMTPAuth = true;
//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";
//Port to connect smtp
	$mail->Port = "587";
//Set gmail username
	$mail->Username = "cyberskull44@gmail.com";
//Set gmail password
	$mail->Password = "chetu_batra@mudit44";
//Email subject
	$mail->Subject = "Registered";
//Set sender email
	$mail->setFrom('cyberskull44@gmail.com');
//Enable HTML
	$mail->isHTML(true);
//Attachment

//Email body
	$mail->Body = "<h1>You have successfully registered to Cyber Skull. We will keep you up to date with the latest events in the cyber world.</h1></br><h2>Thank You</h2>";
//Add recipient
	$mail->addAddress($_POST['email']);
//Finally send email
	if ( $mail->send() ) {
		echo "Email Sent..!";
	}else{
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}

//Closing smtp connection
	$mail->smtpClose();
$conn->close();
header('Location: index.html');
}
}
?>
