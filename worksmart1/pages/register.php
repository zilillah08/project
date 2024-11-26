<?php
require '../controllers/function.php';
checkAuthorized();
?>
<!-- HTML Document -->
<html>
  <head>
    <!-- Document Title -->
    <title class="brand-color">Daftar Sekarang</title>

    <!-- Favicons -->
    <link href="assets/img/logo-worksmart.png" rel="icon" />
    <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon" />

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
    <link href="assets/css/brand.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
      /* Body Styles */
      body {
        background-color: #02396f;
        font-family: "Arial", sans-serif;
      }

      /* Container Styles */
      .container {
        background-color: white;
        padding: 30px;
        max-width: 85%;
        margin: 50px auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      /* Form Element Styles */
      .form-control {
        border-radius: 8px;
        margin-bottom: 15px;
        padding: 12px 15px;
      }
      .form-check-label {
        font-size: 14px;
      }

      /* Button Styles */
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

      /* Footer Styles */
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

      /* Logo Styles */
      .logo {
        text-align: center;
        margin-top: 20px;
      }
      .logo img {
        max-width: 100px;
      }

      /* Input Group Styles */
      .input-group .input-group-text {
        border-radius: 8px 0 0 8px;
        padding: 12px 15px;
      }
      .input-group .form-control {
        border-radius: 0 8px 8px 0;
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
          <h2 class="brand-color">Daftar Sekarang</h2>
          <form method="POST" action="../controllers/controller.php">
            <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
              <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
              ?>
            </div>
            <?php endif; ?>
            <!-- Name Fields Section -->
            <div class="row">
              <div class="col-md-6">
                <label for="firstname" class="form-label brand-color"
                  >First name</label
                >
                <input
                  class="form-control"
                  id="firstname"
                  name="first_name"
                  type="text"
                  required
                />
              </div>
              <div class="col-md-6">
                <label for="lastname" class="form-label brand-color"
                  >Last name</label
                >
                <input
                  class="form-control"
                  id="lastname"
                  name="last_name"
                  type="text"
                  required
                />
              </div>
            </div>

            <!-- Contact Information Section -->
            <label for="email" class="form-label brand-color"
              >Alamat Email</label
            >
            <input
              class="form-control"
              id="email"
              name="email"
              type="email"
              required
            />

            <!-- Nomor hp -->
            <label for="phone" class="form-label brand-color"
              >Nomor Telepon</label
            >
            <input
              class="form-control"
              id="phone"
              name="phone"
              type="number"
              required
              oninput="formatPhoneNumber(this)"
            />

            <!-- Password Section -->
            <label for="password" class="form-label brand-color"
              >Password</label
            >
            <input
              class="form-control"
              id="password"
              name="password"
              type="password"
              required
            />
            <small class="brand-color">
              Gunakan 8 karakter atau lebih dengan campuran huruf, angka &
              simbol
            </small>

            <!-- Role Selection Section -->
            <div class="row mt-3 mb-4">
              <div class="col-md-6">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    id="peserta"
                    name="role"
                    type="radio"
                    value="user"
                    required
                  />
                  <label class="form-check-label brand-color" for="peserta">
                    Peserta
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input
                    class="form-check-input"
                    id="mitra"
                    name="role"
                    type="radio"
                    value="mitra"
                    required
                  />
                  <label class="form-check-label brand-color" for="mitra">
                    Mitra
                  </label>
                </div>
              </div>
            </div>

            <!-- Terms and Conditions Section -->
            <div class="form-check">
              <input
                class="form-check-input"
                id="shareData"
                name="shareData"
                type="checkbox"
                required
              />
              <label class="form-check-label brand-color" for="shareData">
                Share my registration data with our content providers for
                marketing purposes.
              </label>
            </div>

            <!-- Form Submission Section -->
            <div class="row align-items-center">
              <div class="col-md-6">
                <button
                  class="btn btn-primary rounded-pill btn-lg"
                  name="createUser"
                  type="submit"
                >
                  Sign up
                </button>
              </div>
              <div class="col-md-6">
                <p class="brand-color mb-0">
                  Already have an account?
                  <a href="index.php" class="brand-color"> Log in </a>
                </p>
              </div>
            </div>
          </form>
        </div>
        <!-- bagian Image -->
        <div class="col-md-6">
          <div class="d-flex align-items-center justify-content-center h-100">
            <img src="assets/img/logo-worksmart.png" class="img-fluid" />
          </div>
        </div>
      </div>
      <!-- Row End -->
    </div>
  </body>

  <script>
    const loadingOverlay = document.getElementById('loading-overlay');

    function showLoading() {
      loadingOverlay.style.display = 'block';
    }

    function hideLoading() {
      loadingOverlay.style.display = 'none';
    }

    // Tambahkan event listener untuk form submission
    document.querySelector('form').addEventListener('submit', function() {
      showLoading();
    });

    // Tambahkan event listener untuk navigasi halaman
    window.addEventListener('beforeunload', function() {
      showLoading();
    });

    // Sembunyikan loading saat halaman selesai dimuat
    window.addEventListener('load', function() {
      hideLoading();
    });
  </script>


  <script>
    function formatPhoneNumber(input) {
      let value = input.value;
      if (value.startsWith("0")) {
        input.value = "62" + value.substring(1);
      }
    }
  </script>
</html>
