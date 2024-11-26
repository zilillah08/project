<?php
require '../controllers/function.php';
checkAuth();
$payments = getPaymentData($_SESSION['user_id']);
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
      <h1 class="text-light">Data Pembayaran Saya</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Data Pembayaran Saya</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <?php if(isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        <?php 
          echo nl2br($_SESSION['success']);
          unset($_SESSION['success']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php require 'alert.php'; ?>
<section class="section dashboard">
      <div class="row">

        <!-- Full side columns -->
        <div class="col-lg-12">
          <div class="card">
              <div class="card-body">
                <h5 class="card-title">Data Pembayaran Saya</h5>
                <p class="text-dark">Berikut adalah daftar pembayaran saya.</p>
                <a href="dashboard.php"  class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-cart-plus me-2"></i>Pesan Workshop Lagi</a>
                <a href="#" onclick="location.reload();" class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-arrow-clockwise me-2"></i>Refresh</a>              
              
                  <!-- Fetch Data Pembayaran Saya dari db -->
                    <div class="table-responsive">
                      <table class="table table-striped table-hover dt-responsive nowrap" id="participantTable" style="width:100%">
                      <thead>
                          <tr>
                          <th>ID</th>
                          <th>Workshop</th>
                          <th>Mitra</th>
                          <th>Jumlah</th>
                          <th>Metode</th>
                          <th>Status</th>
                          <th>Tanggal</th>
                          <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          $payments = getPaymentData($_SESSION['user_id']);
                          foreach($payments as $payment) {
                          ?>
                          <tr>
                              <td><?= $payment['payment_id'] ?></td>
                              <td><?= $payment['workshop_title'] ?></td>
                              <td><?= $payment['mitra_name'] ?></td>
                              <td>Rp <?= number_format($payment['amount'], 0, ',', '.') ?></td>
                              <td><?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?></td>
                              <td>
                              <span class="badge <?= $payment['payment_status'] == 'successful' ? 'bg-success' : 'bg-danger' ?>">
                                  <?= ucfirst($payment['payment_status']) ?>
                              </span>
                              </td>
                              <td><?= date('d/m/Y H:i', strtotime($payment['payment_date'])) ?></td>
                              <td>
                              <div class="btn-group" role="group">
                                  <button type="button" class="btn btn-sm btn-outline-info me-1 rounded-pill" data-bs-toggle="modal" data-bs-target="#detailModal<?= $payment['payment_id'] ?>" title="Detail"><i class="bi bi-eye"></i></button>
                                  <?php if($payment['payment_status'] == 'successful'): ?>
                                  <a href="print_nota.php?payment_id=<?= $payment['payment_id']; ?>" class="btn btn-sm btn-outline-success rounded-pill" title="Download Invoice"><i class="bi bi-download"></i></a>
                                  <?php endif; ?>
                              </div>
                              </td>
                          </tr>

                          <!-- Detail Modal -->
                          <div class="modal fade" id="detailModal<?= $payment['payment_id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Detail Pembayaran</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">ID Pembayaran</div>
                                    <div class="col-sm-8"><?= $payment['payment_id'] ?></div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">Workshop</div>
                                    <div class="col-sm-8"><?= $payment['workshop_title'] ?></div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">Mitra</div>
                                    <div class="col-sm-8"><?= $payment['mitra_name'] ?></div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">Jumlah</div>
                                    <div class="col-sm-8">Rp <?= number_format($payment['amount'], 0, ',', '.') ?></div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">Metode</div>
                                    <div class="col-sm-8"><?= ucfirst(str_replace('_', ' ', $payment['payment_method'])) ?></div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">Status</div>
                                    <div class="col-sm-8">
                                      <span class="badge <?= $payment['payment_status'] == 'successful' ? 'bg-success' : 'bg-danger' ?>">
                                        <?= ucfirst($payment['payment_status']) ?>
                                      </span>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <div class="col-sm-4 fw-bold">Tanggal</div>
                                    <div class="col-sm-8"><?= date('d/m/Y H:i', strtotime($payment['payment_date'])) ?></div>
                                  </div>
                                </div>

                                <div class="row mb-3 text-center">
                                  <div class="col-sm-12 fw-bold">Bukti Pembayaran</div>
                                  <div class="col-sm-12">
                                    <?php if($payment['payment_receipt']): ?>
                                      <img src="assets/img/payment/<?= $payment['payment_receipt'] ?>" 
                                          class="img-fluid" 
                                          alt="Bukti Pembayaran"
                                          style="max-width: 300px;">
                                    <?php else: ?>
                                      <span class="text-muted">Bukti pembayaran belum diunggah</span>
                                    <?php endif; ?>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <?php if($payment['payment_status'] == 'successful'): ?>
                                  <a href="print_nota.php?payment_id=<?= $payment['payment_id']; ?>" class="btn brand-btn">Download Invoice</a>
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php } ?>
                      </tbody>
                      </table>
                  </div>
              </div>
            </div>
          </div>        <!-- Full side columns -->


      </div>
    </section>  
  </main>
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