<?php
require '../controllers/function.php';
checkAuth();
$kategori = $_GET['kategori'];
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
      <h1 class="text-light">Export Laporan <?= $kategori; ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Export Laporan <?= $kategori; ?></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <?php require 'alert.php'; ?>
<section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <i class="bi bi-file-earmark-text me-2"></i>
                Laporan Data <?= ucfirst($kategori) ?>
              </h5>

              <form id="reportForm" action="print_laporan.php" method="POST" target="_blank">
                <input type="hidden" name="kategori" value="<?= $kategori ?>">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label fw-bold">Periode Awal</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label fw-bold">Periode Akhir</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                      <input type="date" class="form-control" id="endDate" name="end_date" required>
                    </div>
                  </div>
                </div>

                <div class="col-12 mt-4">
                  <button type="submit" class="btn btn-primary brand-bg-color rounded-pill">
                    <i class="bi bi-printer me-2"></i>Export Laporan
                  </button>
                </div>
              </form>

            </div>
          </div>
        </div>
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
  <script>
      $(document).ready(function() {
          let today = new Date();
          let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
          
          $('#startDate').val(firstDay.toISOString().split('T')[0]);
          $('#endDate').val(today.toISOString().split('T')[0]);

          $('#reportForm').on('submit', function(e) {
              e.preventDefault();
              generateReport();
          });
      });

      function generateReport() {
          let form = document.createElement('form');
          form.method = 'POST';
          form.action = 'print_laporan.php';
          form.target = '_blank';

          let startDateInput = document.createElement('input');
          startDateInput.type = 'hidden';
          startDateInput.name = 'start_date';
          startDateInput.value = $('#startDate').val();

          let endDateInput = document.createElement('input');
          endDateInput.type = 'hidden';
          endDateInput.name = 'end_date';
          endDateInput.value = $('#endDate').val();

          let kategoriInput = document.createElement('input');
          kategoriInput.type = 'hidden';
          kategoriInput.name = 'kategori';
          kategoriInput.value = '<?= $kategori ?>';

          form.appendChild(startDateInput);
          form.appendChild(endDateInput);
          form.appendChild(kategoriInput);

          document.body.appendChild(form);
          form.submit();
          document.body.removeChild(form);
      }
    </script>
</body>

</html>