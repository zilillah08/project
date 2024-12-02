change_password_process.php


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil email dan password baru dari form
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'worksmart1');
    if ($conn->connect_error) {
        die('Could not connect to the database');
    }

    // Update password di database dengan prepared statement untuk menghindari SQL Injection
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT); // Hash password

    // Gunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password_hash, $email);

    if ($stmt->execute()) {
        // Redirect ke halaman success.html jika berhasil
        header("Location: success.html");
        exit(); // Pastikan script berhenti setelah redirect
    } else {
        echo "Error updating password.";
    }

    // Menutup statement dan koneksi ke database
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Document Title -->
    <title class="brand-color">Forgot Password</title>
<!-- Favicons -->
<link href="pages/assets/img/logo-worksmart.png" rel="icon">
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