<?php

use Core\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get form input data
$email = htmlspecialchars(trim($_POST['email']));
$subject = htmlspecialchars(trim($_POST['subject']));
$message = htmlspecialchars(trim($_POST['message']));


// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP server settings
    $mail->isSMTP();                                     // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                      // Specify SMTP server
    $mail->SMTPAuth = true;                              // Enable SMTP authentication
    $mail->Username = getenv("EMAIL");            // SMTP username (your Gmail address)
    $mail->Password = getenv("EMAIL_PASSWORD");             // SMTP password (your Gmail password or app password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
    $mail->Port = 587;                                   // TCP port to connect to

    // Sender and recipient settings
    $mail->setFrom($email);                       // Sender's email and name
    $mail->addAddress($email);     // Add the recipient

    // Email content
    $mail->isHTML(true);                                 // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = "
         <h3>Contact Form Submission</h3>
         <p><strong>Email:</strong> {$email}</p>
         <p><strong>Message:</strong><br>{$message}</p>
     ";

    $result = "";
    // Send the email
    if ($mail->send()) {
        $result = "Message sent successfully!";
    } else {
        $result = "Message could not be sent.";
    }
} catch (Exception $e) {
    $result = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

Session::flash("result",$result);
Session::flash("subject",$subject);
Session::flash("message",$message);

redirect("/contact");
