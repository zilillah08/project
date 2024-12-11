<?php
if (isset($_POST['reset'])) {
    $email = $_POST['email'];
} else {
    exit('No reset request received.');
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

$mail = new PHPMailer(true);

try {
    // Konfigurasi SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'worksmartwmk@gmail.com';
    $mail->Password   = 'maab qxdb djry toks';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Penerima email
    $mail->setFrom('worksmartwmk@gmail.com', 'WorkSmart');
    $mail->addAddress($email);

    // Generate kode reset password
    $code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset';
    $mail->Body = 'To reset your password, click <a href="http://localhost/project/worksmart1/pages/change_password.php?email=' . urlencode($email) . '&code=' . $code . '">here</a>. </br>Reset your password within a day.';

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'worksmart1');

    if ($conn->connect_error) {
        die('Could not connect to the database.');
    }

    // Debug: Periksa struktur tabel
    $result = $conn->query("SHOW COLUMNS FROM users");
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . '<br>'; // Menampilkan nama kolom untuk memastikan kolom 'code' ada
    }

    // Verifikasi email
    $verifyQuery = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($verifyQuery->num_rows > 0) {
        // Update kode reset password
        $codeQuery = $conn->query("UPDATE users SET code = '$code' WHERE email = '$email'");
        if (!$codeQuery) {
            die('Query failed: ' . $conn->error);
        }

        // Kirim email
        $mail->send();
        echo '<script>alert("Message has been sent, check your email");</script>';
    } else {
        echo '<script>alert("Email not registered.");</script>';
    }

    $conn->close();

} catch (Exception $e) {
    echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
}
?>
