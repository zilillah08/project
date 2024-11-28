<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Document Title -->
    <title class="brand-color">Forgot Password Sekarang</title>

    <!-- Favicons -->
    <link href="pages/assets/img/logo-worksmart.png" rel="icon" />
    <link href="pages/assets/img/logo-worksmart.png" rel="apple-touch-icon" />

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
      .container {
        background-color: white;
        padding: 30px;
        max-width: 85%;
        margin: 50px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      .form-control {
        border-radius: 8px;
        margin-bottom: 15px;
        padding: 12px 15px;
      }
      .btn-primary {
        background-color: #cccccc;
        border: none;
        color: #666666;
        padding: 10px 20px;
        border-radius: 5px;
      }
      .btn-primary:hover {
        background-color: #bbbbbb;
      }
      .footer-links {
        text-align: center;
        margin-top: 20px;
      }
      .footer-links a {
        color: #666666;
        margin: 0 10px;
        text-decoration: none;
      }
      .footer-links a:hover {
        text-decoration: underline;
      }
      .logo {
        text-align: center;
        margin-top: 20px;
      }
      .logo img {
        max-width: 100px;
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
    <!-- Registration Form Container -->
    <div class="container rounded-4">
      <!-- Row start -->
      <div class="row">
        <!-- Bagian Form -->
        <div class="col-md-6">
          <h2 class="brand-color">Forgot Password</h2>
          <form method="POST" action="forgot_password_process.php">
            <br>
            <!-- Error message section (if exists) -->
            <div class="alert alert-danger" style="display: none;" id="error-message">
              <!-- Error message will be injected here -->
            </div>

            <!-- Email Input -->
            <label for="email" class="form-label brand-color">Email</label>
            <input
              class="form-control"
              id="email"
              name="email"
              type="email"
              required
            />

            <!-- Form Submission Section -->
            <div class="d-grid">
              <button type="submit" class="btn btn-outline-primary btn-lg rounded-pill" name="reset">Reset</button>
            </div>
          </form>
        </div>
        <!-- Bagian Image -->
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-center h-100">
            <img src="pages/assets/img/logo-worksmart.png" class="img-fluid" />
          </div>
        </div>
      </div>
      <!-- Row End -->
    </div>

    <script>
      const loadingOverlay = document.getElementById('loading-overlay');

      function showLoading() {
        loadingOverlay.style.display = 'block';
      }

      function hideLoading() {
        loadingOverlay.style.display = 'none';
      }

      document.querySelector('form').addEventListener('submit', function() {
        showLoading();
      });

      window.addEventListener('beforeunload', function() {
        showLoading();
      });

      window.addEventListener('load', function() {
        hideLoading();
      });

      // If error message exists, display it (optional)
      // For demo purposes
      setTimeout(function() {
        const errorMessage = document.getElementById('error-message');
      }, 2000); // simulating an error after 2 seconds
    </script>
  </body>
</html>
