<?php
require '../controllers/function.php';
checkAuth();
$data = getFinancialDataAdmin();

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
      <h1 class="text-light">Data Keuangan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Data Keuangan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <?php require 'alert.php'; ?>
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
        
            <!-- Penghasilan Card -->
            <div class="col-xxl-6 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Penghasilan</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                    <h6> Rp. <?php echo number_format(countTotalEarnings() ?? 0); ?> </h6>
                    <span class="text-muted small pt-2">Total Penghasilan</span>
                  </div>
                  </div>
                </div>
              </div>
            </div>
        
            <!-- Pengeluaran Card -->
            <div class="col-xxl-6 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Pengeluaran</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>Rp. 0</h6>
                      <span class="text-muted small pt-2">Total Pengeluaran</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        
          </div>
        </div>
        

        <!-- Full side columns -->
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Keuangan</h5>
              <p class="text-dark">Berikut adalah data keuangan.</p>
              <a href="laporan.php?kategori=Keuangan" class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-cash me-2"></i>Export Data</a>
              <a href="#" onclick="location.reload();" class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-arrow-clockwise me-2"></i>Refresh</a>              
              
              <!-- Fetch Data Keuangan dari db -->
              <div class="table-responsive">
              <table class="table table-striped table-hover dt-responsive nowrap" id="participantTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Workshop</th>
                      <th>Nama Mitra</th>
                      <th>Nama Pendaftar</th>
                      <th>Status Bayar</th>
                      <th>Metode Bayar</th>
                      <th>Tanggal Bayar</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    foreach($data as $datas) {
                    ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $datas['nama_workshop'] ?></td>
                        <td><?= $datas['nama_mitra'] ?></td>
                        <td><?= $datas['nama_peserta'] ?></td>
                        <td>
                          <?php if($datas['payment_status'] == 'pending'): ?>
                            <span class="badge bg-warning">Pending</span>
                          <?php elseif($datas['payment_status'] == 'successful'): ?>
                            <span class="badge bg-success">Sukses</span>
                          <?php else: ?>
                            <span class="badge bg-danger">Gagal</span>
                          <?php endif; ?>
                        </td>
                        <td><?= $datas['payment_method'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($datas['payment_date'])) ?></td>
                        <td>Rp. <?= number_format($datas['amount'], 0, ',', '.') ?></td>
                        <td>
                          <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $datas['payment_id'] ?>">
                            <i class="bi bi-eye"></i>
                          </button>
                          <?php if($datas['payment_status'] != 'successful'): ?>
                            <button id="verifyBtn<?= $datas['payment_id'] ?>" class="btn btn-sm btn-success" onclick="verifyPayment(<?= $datas['payment_id'] ?>)">
                              <i class="bi bi-check-circle"></i>
                            </button>
                          <?php endif; ?>
                        </td>
                      </tr>

                      <!-- Detail Modal -->
                      <div class="modal fade" id="detailModal<?= $datas['payment_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel<?= $datas['payment_id'] ?>" aria-hidden="false">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="detailModalLabel<?= $datas['payment_id'] ?>">Detail Transaksi</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row mb-3">
                                <div class="col-12">
                                  <img src="assets/img/payment/<?= $datas['payment_receipt'] ?>" class="img-fluid" alt="Bukti Transfer">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-6"><strong>Workshop:</strong></div>
                                <div class="col-6"><?= $datas['nama_workshop'] ?></div>
                              </div>
                              <div class="row">
                                <div class="col-6"><strong>Peserta:</strong></div>
                                <div class="col-6"><?= $datas['nama_peserta'] ?></div>
                              </div>
                              <div class="row">
                                <div class="col-6"><strong>Jumlah:</strong></div>
                                <div class="col-6">Rp. <?= number_format($datas['amount']) ?></div>
                              </div>
                              <div class="row">
                                <div class="col-6"><strong>Tanggal:</strong></div>
                                <div class="col-6"><?= $datas['payment_date'] ?></div>
                              </div>
                              <div class="row">
                                <div class="col-6"><strong>Status:</strong></div>
                                <div class="col-6"><?= $datas['payment_status'] ?></div>
                              </div>
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
        </div>
        <!-- Full side columns -->


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

    function verifyPayment(paymentId) {
    if(confirm('Verifikasi pembayaran ini?')) {
        $.ajax({
            url: '../controllers/controller.php',
            type: 'POST',
            data: {
                verifyPayment: true,
                payment_id: paymentId
            },
            success: function(response) {
                alert('Pembayaran berhasil diverifikasi');
                location.reload();
            },
            error: function() {
                alert('Terjadi kesalahan');
            }
        });
    }
}


  </script>

</body>

</html>