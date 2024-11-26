<?php
$workshop_id = $_GET['workshop_id'];
require '../controllers/function.php';
$data = getWorkshopById($workshop_id);
if(!$data){
  header('Location: dashboard.php');
}
checkAuth();
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - WorkSmart</title>
  <meta content="WorkSmart" name="description">
  <meta content="WorkSmart" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo-worksmart.png" rel="icon">
  <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/brand.css" rel="stylesheet">
  
</head>

<body>

  <?php require 'header.php'; ?>
  <?php require 'sidebar.php'; ?>

  <main id="main" class="main brand-bg-color">

    <div class="pagetitle">
      <h1 class="text-light">Tentang Kelas Ini</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Tentang Kelas Ini</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <?php require 'alert.php'; ?>
    <section class="section dashboard">
    <?php if($role!='admin' && $role!='mitra'){ ?>
        <div class="row">
          <!-- Full side columns -->
          <div class="col-lg-12">
            <div class="card shadow-lg rounded-4">
              <div class="card-body">
                <!-- Wizard Navigation -->
                <div class="wizard-nav mb-4">
                  <ul class="nav nav-pills nav-justified mt-4 brand-bg-color rounded-pill">
                    <li class="nav-item">
                      <a class="nav-link active rounded-pill text-light" id="step1-tab" data-bs-toggle="pill" href="#step1">
                        <span class="step badge bg-primary rounded-circle">1</span>
                        <span>Detail Workshop</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link rounded-pill text-light" id="step2-tab" data-bs-toggle="pill" href="#step2">
                        <span class="step badge bg-primary rounded-circle">2</span>
                        <span>Pembayaran</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link rounded-pill text-light" id="step3-tab" data-bs-toggle="pill" href="#step3">
                        <span class="step badge bg-primary rounded-circle">3</span>
                        <span>Konfirmasi Pembayaran</span>
                      </a>
                    </li>
                  </ul>
                </div>

                <!-- Wizard Content -->
                <div class="tab-content">
                  <!-- Step 1: Detail Workshop -->
                  <div class="tab-pane fade show active" id="step1">
                    <div class="row">
                      <div class="col-lg-6 text-left">
                          <h5 class="card-title brand-color fw-bold"><i class="bi bi-book-half"></i> Tentang Kelas Ini</h5>
                          <div class="p-3 bg-light rounded-3 mb-3">
                            <h5 class="brand-color"><i class="bi bi-lightbulb"></i> Training Overview</h5>
                            <h6><?= $data['training_overview']; ?></h6>
                          </div>
                          
                          <div class="p-3 bg-light rounded-3 mb-3">
                            <h5 class="brand-color"><i class="bi bi-trophy"></i> Kompetensi yang Dilatih</h5>
                            <h6><?= $data['trained_competencies']; ?></h6>
                          </div>
                          
                          <div class="p-3 bg-light rounded-3 mb-3">
                            <h5 class="brand-color"><i class="bi bi-calendar3"></i> Sesi Pelatihan</h5>
                            <h6><?= $data['training_session']; ?></h6>
                          </div>
                          
                          <div class="p-3 bg-light rounded-3 mb-3">
                            <h5 class="brand-color"><i class="bi bi-check2-circle"></i> Persyaratan</h5>
                            <h6><?= $data['requirements']; ?></h6>
                          </div>
                          
                          <div class="p-3 bg-light rounded-3">
                            <h5 class="brand-color"><i class="bi bi-gift"></i> Manfaat</h5>
                            <h6><?= $data['benefits']; ?></h6>
                          </div>
                      </div>
                      <div class="col-lg-6 text-center mt-5">
                          <!-- Workshop Summary -->
                          <div class="card shadow-sm hover-shadow mt-3">
                              <div class="card-body">
                                  <div class="position-relative">
                                    <img src="assets/img/workshops/<?= $data['banner']; ?>" alt="Workshop Banner" class="rounded-3 img-fluid mb-3" style="max-height: 200px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-2">
                                      <span class="badge bg-primary"><?= ucfirst($data['status']) ?></span>
                                    </div>
                                  </div>
                                  <h5 class="card-title fw-bold"><?= $data['title']; ?></h5>
                                  <h4 class="text-primary mb-0 fw-bold">Rp. <?= number_format($data['price'], 0, ',', '.') ?></h4>
                              </div>
                          </div>
                      </div>
                    </div>
                    <!-- Konten Detail Kelas -->
                    <div class="row mt-5">
                      <div class="col-lg-8">
                          <div class="workshop-details">
                              <div class="info-block mb-4 p-4 bg-light rounded-4">
                                  <h4 class="text-dark fw-bold"><i class="bi bi-info-circle-fill text-primary"></i> Informasi Workshop</h4>
                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <ul class="list-unstyled">
                                              <li class="mb-3 d-flex align-items-center">
                                                <span class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                  <i class="bi bi-calendar-event text-success"></i>
                                                </span>
                                                Mulai: <?= date('d F Y H:i', strtotime($data['start_date'])) ?>
                                              </li>
                                              <li class="mb-3 d-flex align-items-center">
                                                <span class="icon-wrapper bg-danger bg-opacity-10 rounded-circle p-2 me-2">
                                                  <i class="bi bi-calendar-check text-danger"></i>
                                                </span>
                                                Selesai: <?= date('d F Y H:i', strtotime($data['end_date'])) ?>
                                              </li>
                                              <li class="mb-3 d-flex align-items-center">
                                                <span class="icon-wrapper bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                                                  <i class="bi bi-geo-alt text-warning"></i>
                                                </span>
                                                Lokasi: <?= $data['location'] ?>
                                              </li>
                                          </ul>
                                      </div>
                                      <div class="col-md-6">
                                          <ul class="list-unstyled">
                                              <li class="mb-3 d-flex align-items-center">
                                                <span class="icon-wrapper bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                  <i class="bi bi-currency-dollar text-info"></i>
                                                </span>
                                                Harga: Rp <?= number_format($data['price'], 0, ',', '.') ?>
                                              </li>
                                              <li class="mb-3 d-flex align-items-center">
                                                <span class="icon-wrapper bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                  <i class="bi bi-clock-history text-primary"></i>
                                                </span>
                                                Durasi: <?= ceil((strtotime($data['end_date']) - strtotime($data['start_date'])) / (60 * 60 * 24)) ?> hari
                                              </li>
                                              <li class="mb-3 d-flex align-items-center">
                                                <span class="icon-wrapper bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                                  <i class="bi bi-check-circle text-success"></i>
                                                </span>
                                                Status: <?= ucfirst($data['status']) ?>
                                              </li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    
                      <div class="col-lg-4">
                          <div class="card shadow-sm hover-shadow">
                              <div class="card-body">
                                  <h5 class="card-title fw-bold"><i class="bi bi-lightning-charge"></i> Daftar Sekarang</h5>
                                  <div class="d-grid gap-2">
                                      <?php if($data['status'] == 'active'): ?>
                                          <button class="btn brand-btn rounded-pill btn-lg" type="button" onclick="nextStep()">
                                              <i class="bi bi-cart-fill"></i> Beli Sekarang
                                          </button>
                                          <a href="pesan.php?mitra_id=<?= $data['mitra_id'] ?>&workshop_title=<?= urlencode($data['title']) ?>" class="btn btn-outline-info rounded-pill btn-lg" type="button">
                                              <i class="bi bi-chat-text-fill"></i> Tanya Informasi
                                      </a>
                                      <?php else: ?>
                                          <button class="btn btn-secondary btn-lg" type="button" disabled>
                                              <i class="bi bi-x-circle"></i> Workshop Tidak Tersedia
                                          </button>
                                      <?php endif; ?>
                                  </div>
                              </div>
                          </div>
                        
                          <div class="card mt-3 shadow-sm hover-shadow">
                              <div class="card-body">
                                  <h5 class="card-title fw-bold"><i class="bi bi-share"></i> Share Workshop</h5>
                                  <div class="d-flex justify-content-around">
                                      <a href="#" class="btn btn-primary rounded-circle"><i class="bi bi-facebook"></i></a>
                                      <a href="#" class="btn btn-info rounded-circle"><i class="bi bi-twitter"></i></a>
                                      <a href="#" class="btn btn-success rounded-circle"><i class="bi bi-whatsapp"></i></a>
                                      <a href="#" class="btn btn-danger rounded-circle"><i class="bi bi-envelope"></i></a>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>

                  <!-- Step 2: Pembayaran -->
                  <div class="tab-pane fade" id="step2">
                    <div class="row justify-content-center">
                      <div class="col-lg-8">
                        <div class="card shadow-lg">
                          <div class="card-body">
                            <h5 class="card-title fw-bold"><i class="bi bi-credit-card"></i> Pilih Metode Pembayaran</h5>
                            <form>
                              <div class="mb-4">
                                <div class="payment-option mb-3 p-3 border rounded-3 hover-shadow">
                                  <input class="form-check-input" type="radio" name="paymentMethod" id="transfer" value="transfer" checked>
                                  <label class="form-check-label ms-2" for="transfer">
                                    <i class="bi bi-bank text-primary"></i> Transfer Bank
                                  </label>
                                </div>
                                <div class="payment-option mb-3 p-3 border rounded-3 hover-shadow">
                                  <input class="form-check-input" type="radio" name="paymentMethod" id="ewallet" value="ewallet" disabled>
                                  <label class="form-check-label ms-2" for="ewallet">
                                    <i class="bi bi-wallet2 text-success"></i> E-Wallet
                                  </label>
                                </div>
                                <div class="payment-option mb-3 p-3 border rounded-3 hover-shadow">
                                  <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="creditCard" disabled>
                                  <label class="form-check-label ms-2" for="creditCard">
                                    <i class="bi bi-credit-card text-danger"></i> Kartu Kredit
                                  </label>
                                </div>
                              </div>
                              <div class="d-grid gap-2">
                                <button type="button" class="btn btn-secondary btn-lg rounded-pill" onclick="prevStep()">
                                  <i class="bi bi-arrow-left"></i> Kembali
                                </button>
                                <button type="button" class="btn brand-btn btn-lg rounded-pill" onclick="nextStepConfirm()">
                                  <i class="bi bi-check2-circle"></i> Lanjutkan Pembayaran
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Step 3: Konfirmasi Pembayaran -->
                  <div class="tab-pane fade" id="step3">
                    <div class="row justify-content-center">
                      <div class="col-lg-8">
                        <div class="card shadow-lg">
                          <div class="card-body">
                          <form id="paymentForm" action="../controllers/controller.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="workshop_id" value="<?= $workshop_id ?>">
                            <input type="hidden" name="amount" value="<?= $data['price'] ?>">
                            <input type="hidden" name="bank_id" id="selected_bank_id">

                            <h5 class="card-title fw-bold"><i class="bi bi-bank"></i> Pilih Bank</h5>
                            <div class="mb-4">
                              <label for="bankSelect" class="form-label">Pilih Bank</label>
                              <select class="form-select" id="bankSelect" onchange="showBankDetails()" required>
                                <option value="">Pilih Bank</option>
                                <!-- Opsi bank akan diisi secara dinamis dari database -->
                              </select>
                            </div>

                            <div id="bankDetailsContainer" class="mt-4 p-3 bg-light rounded-3">
                              <div id="bankDetails">
                                <!-- Previous bank details code remains -->
                              </div>
    
                              <div class="mb-3">
                                <label class="form-label">Total Pembayaran</label>
                                <div class="input-group">
                                  <span class="input-group-text">Rp</span>
                                  <input type="text" class="form-control" value="<?= number_format($data['price'], 0, ',', '.') ?>" disabled>
                                </div>
                              </div>

                              <div class="mb-3">
                                <label for="payment_receipt" class="form-label">Upload Bukti Transfer</label>
                                <input type="file" class="form-control" id="payment_receipt" name="payment_receipt" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG, JPEG. Max size: 2MB</small>
                              </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                              <button type="button" class="btn btn-secondary btn-lg rounded-pill" onclick="prevStepToPayment()">
                                <i class="bi bi-arrow-left"></i> Kembali
                              </button>
                              <button type="submit" name="bayar" class="btn brand-btn btn-lg rounded-pill">
                                <i class="bi bi-check2-circle"></i> Kirim Bukti Pembayaran
                              </button>
                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <?php }else{
      echo "
      <div class='row text-center mt-5 mb-5'>
        <div class='col-12 mt-5 mb-5'>
            <h1 class='text-center mt-5 mb-5'> Mohon maaf, halaman ini hanya dapat diakses oleh peserta </h1>
        </div>
      </div>
      ";
    } ?>
      </section>

      <script>
        function nextStep() {
          document.getElementById('step2-tab').click();
        }

        function prevStep() {
          document.getElementById('step1-tab').click();
        }

        // Fungsi untuk kembali ke step pembayaran
        function prevStepToPayment() {
        document.getElementById('step2-tab').click();
        }

        // Modifikasi fungsi nextStep untuk menuju step 3
        function nextStepConfirm() {
          document.getElementById('step3-tab').click();
        }

        document.getElementById('step3-tab').addEventListener('click', function() {
          loadBanks();
        });


        // Add hover effect for payment options
        document.querySelectorAll('.payment-option').forEach(option => {
          option.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#f8f9fa';
          });
          option.addEventListener('mouseout', function() {
            this.style.backgroundColor = 'white';
          });
        });

        function loadBanks() {
            fetch('../controllers/get_banks.php', {
              headers: {
                'Accept': 'application/json'
              }
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(banks => {
              const bankSelect = document.getElementById('bankSelect');
              bankSelect.innerHTML = '<option value="">Pilih Bank</option>';
              
              banks.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank.id;
                option.textContent = bank.name;
                bankSelect.appendChild(option);
              });
            })
            .catch(error => {
              const bankSelect = document.getElementById('bankSelect');
              bankSelect.innerHTML = '<option value="">Error: Failed to load banks</option>';
            });
          }

          function showBankDetails() {
            const bankId = document.getElementById('bankSelect').value;
            document.getElementById('selected_bank_id').value = bankId; // Add this line

            if (!bankId) {
              bankDetails.innerHTML = '<p class="text-muted text-center">Pilih bank untuk melihat detail</p>';
              return;
            }

            fetch(`../controllers/get_bank_details.php?id=${bankId}`, {
              headers: {
                'Accept': 'application/json'
              }
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              // Generate QR Code using an open API (using QR Server API)
              const qrData = `${data.account_number}`;
              const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(qrData)}`;

              bankDetails.innerHTML = `
                <div class="alert brand-bg-color">
                  <div class="row">
                    <div class="col-md-6">
                      <p><strong><i class="bi bi-bank"></i> Bank:</strong> ${data.name}</p>
                      <p><strong><i class="bi bi-person"></i> Atas Nama:</strong> ${data.account_name}</p>
                    </div>
                    <div class="col-md-6">
                      <p><strong><i class="bi bi-credit-card"></i> No. Rekening:</strong> ${data.account_number}</p>
                      <p><strong><i class="bi bi-upc"></i> Swift Code:</strong> ${data.swift_code}</p>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-12 text-center">
                      <img src="${qrCodeUrl}" alt="QR Code" class="img-fluid" style="max-width: 150px;">
                      <p class="mt-2"><small>Scan QR untuk menyalin nomor rekening.</small></p>
                    </div>
                  </div>
                </div>
              `;
            })
            .catch(error => {
              bankDetails.innerHTML = `
                <div class="alert alert-danger">
                  <i class="bi bi-exclamation-triangle"></i> Failed to load bank details
                </div>
              `;
            });
          }

        function testFetch(){
        // Basic fetch
        fetch('../controllers/get_banks.php')
              .then(res => res.json())
              .then(data => console.log('Banks:', data))
              .catch(err => console.error('Error:', err));

            // Fetch with options
            fetch('../controllers/get_banks.php', {
              method: 'GET',
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
              }
            })
            .then(res => res.json())
            .then(data => {
              console.table(data); // Shows data in table format
              data.forEach(bank => {
                console.log(`Bank ID: ${bank.id}, Name: ${bank.name}`);
              });
            })
            .catch(err => console.error('Error:', err));
        }

      </script>

      <style>
        .hover-shadow:hover {
          transform: translateY(-3px);
          box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
          transition: all 0.3s ease;
        }
        
        .icon-wrapper {
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 35px;
          height: 35px;
        }
      </style>  </main>
  </main><!-- End #main -->

  <?php require "modals.php";?>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer brand-bg-color">
    <div class="copyright text-light">
      © Copyright <strong><span>WorkSmart</span></strong>. All Rights Reserved
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  
  <!-- DataTables JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/autohide.js"></script>

  <!-- Initialize DataTable -->
  <script>
    $(document).ready(function() {
      $('#participantTable').DataTable({
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
          {
            extend: 'copy',
            className: 'btn btn-sm btn-primary'
          },
          {
            extend: 'excel',
            className: 'btn btn-sm btn-success'
          },
          {
            extend: 'pdf',
            className: 'btn btn-sm btn-danger'
          },
          {
            extend: 'print',
            className: 'btn btn-sm btn-info'
          }
        ],  
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search records...",
          lengthMenu: "_MENU_ records per page",
          info: "Showing _START_ to _END_ of _TOTAL_ entries",
          paginate: {
            first: '<i class="bi bi-chevron-double-left"></i>',
            previous: '<i class="bi bi-chevron-left"></i>',
            next: '<i class="bi bi-chevron-right"></i>',
            last: '<i class="bi bi-chevron-double-right"></i>'
          }
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']],
        drawCallback: function() {
          $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
      });
    });
  </script>

</body>

</html>