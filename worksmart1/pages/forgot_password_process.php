


<?php
if (isset($_POST['reset'])) {
    $email = $_POST['email'];
} else {
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

// Instantiation and passing true enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                        // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
    $mail->Username   = 'pmaya0338@gmail.com';                   // SMTP username
    $mail->Password   = 'skjp iigu rjbm fqnn';                   // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS encouraged
    $mail->Port       = 587;                                     // TCP port to connect to, use 465 for PHPMailer::ENCRYPTION_SMTPS above

    //Recipients
    $mail->setFrom('pmaya0338@gmail.com', 'WorkSmart');
    $mail->addAddress($email);     // Add a recipient

    $code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body = 'To reset your password click <a href="http://localhost/project/worksmart1/pages/change_password.php?email=' . ($email) . '">here</a>. </br>Reset your password in a day.';


    $conn = new mysqli('localhost', 'root', '', 'worksmart1');

    if ($conn->connect_error) {
        die('Could not connect to the database.');
    }

    $verifyQuery = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if ($verifyQuery->num_rows) {
        $codeQuery = $conn->query("UPDATE users SET code = '$code' WHERE email = '$email'");


        // Send email
        $mail->send();

        // Display success message with JavaScript alert
        echo '<script>alert("Message has been sent, check your email");</script>';
    }

    $conn->close();

} catch (Exception $e) {
    // Display error message with JavaScript alert
    echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Document Title -->
    <title class="brand-color">Forgot Password</title>
<!-- Favicons -->
<link href="../pages/assets/img/logo-worksmart.png" rel="icon">
    <!-- External CSS Links -->
    <link
      crossorigin="anonymous"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      rel="stylesheet"
    />
    <link href="pages/assets/css/brand.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
      body {
        background-color: #02396f;
        font-family: "Arial", sans-serif;
      }
    </style>
  </head>

  <body>
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
      <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
    <!-- Your page content goes here -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>