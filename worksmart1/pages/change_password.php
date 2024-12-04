



<?php
if (isset($_GET['email'])) {
    // Ambil nilai 'email' dari URL
    $email = $_GET['email'];

    // Koneksi ke database untuk memverifikasi email (opsional, jika perlu)
    $conn = new mysqli('localhost', 'root', '', 'worksmart1');
    if ($conn->connect_error) {
        die('Could not connect to the database');
    }

    // Verifikasi apakah email ada dalam database
    $query = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($query->num_rows == 0) {
        // Jika email tidak ditemukan
        echo "Email not found.";
        exit();
    }

    // Menutup koneksi ke database
    $conn->close();
} else {
    // Jika parameter 'email' tidak ada, tampilkan pesan error
    echo "Email parameter is missing.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Document Title -->
   <title class="brand-color">Change Password</title>

    <!-- Favicons -->
    <link href="assets/img/logo-worksmart.png" rel="icon" />
    <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon" />

   <!-- External CSS Links -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
   <link href="pages/assets/css/brand.css" rel="stylesheet" />

   <!-- Vendor JS Files -->
   <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <style>
     body { background-color: #02396f; font-family: "Arial", sans-serif; }
     .container { background-color: white; padding: 30px; max-width: 85%; margin: 50px auto; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
     .form-control { border-radius: 8px; margin-bottom: 15px; padding: 12px 15px; }
     .btn-primary { background-color: #cccccc; border: none; color: #666666; padding: 10px 20px; border-radius: 5px; }
     .btn-primary:hover { background-color: #bbbbbb; }
     .footer-links { text-align: center; margin-top: 20px; }
     .footer-links a { color: #666666; margin: 0 10px; text-decoration: none; }
     .footer-links a:hover { text-decoration: underline; }
     .password-toggle {
        border-radius: 0 8px 8px 0;
        height: 100%;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        background: #f8f9fa;
        border: 1px solid #ced4da;
        cursor: pointer;
    }
   </style>
   <script>
document.addEventListener('DOMContentLoaded', function() {
      const togglePassword = document.querySelector('#togglePassword');
      const passwordField = document.querySelector('#password');
      
      togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.textContent = type === 'password' ? 'Show' : 'Hide';
      });
    });
</script>
 </head>
<body>
  <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>

  <!-- Form untuk Ubah Password -->
  <div class="container rounded-4">
    <div class="row">
      <div class="col-md-6">
        <h2 class="brand-color">Change Password</h2>
        <!-- Email Section -->
        <form method="POST" action="change_password_process.php">
          <label for="inputEmail" class="form-label brand-color">Email</label>
          <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required />

          <!-- Password Section -->
          <div class="mb-3">
                  <label for="inputPassword" class="form-label brand-color">New Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control password-input" id="password" name="password" placeholder="Password" required>
                    <button class="btn btn-outline-secondary password-toggle" type="button" id="togglePassword">Hide</button>
                  </div>
                </div>

          <!-- Submit Button -->
          <div class="d-grid">
            <button type="submit" class="btn btn-outline-primary btn-lg rounded-pill" name="change">Change</button>
          </div>
        </form>
      </div>
       <!-- Bagian Image -->
       <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-center h-100">
          <a href="../pages/index.php">
            <img src="../pages/assets/img/logo-worksmart.png" class="img-fluid" alt="Logo Worksmart" />
          </a>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>