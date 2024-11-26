<?php
require '../controllers/function.php';
checkAuth();
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
      <h1 class="text-light">Data Mitra</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Data Mitra</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <?php require 'alert.php'; ?>
<section class="section dashboard">
      <div class="row">

        <!-- Full side columns -->
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Data Mitra</h5>
              <p class="text-dark">Berikut adalah daftar peserta yang terdaftar dalam sistem.</p>
              <a href="#" data-bs-toggle="modal" data-bs-target="#tambahMitra" class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-person-plus me-2"></i>Tambah Mitra</a>
              <a href="#" onclick="location.reload();" class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-arrow-clockwise me-2"></i>Refresh</a>              
              
              <!-- Fetch Data Mitra dari db -->
              <div class="table-responsive">
                <table class="table table-striped table-hover dt-responsive nowrap" id="participantTable" style="width:100%">
                <thead>
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $users = getUsersByRole('mitra');
                  foreach($users as $user) {
                  
                    ?>
                    <tr>
                      <td><?= $user['first_name'] ?></td>
                      <td><?= $user['last_name'] ?></td>
                      <td><?= $user['username'] ?></td>
                      <td><?= $user['email'] ?></td>
                      <td><?= $user['phone'] ?></td>
                      <td class="text-center">
                        <div class="btn-group" role="group">
                          <button type="button" class="btn btn-sm btn-outline-warning me-1 rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['user_id'] ?>" title="Edit"><i class="bi bi-pencil-square"></i></button>
                          <a href="https://wa.me/<?= $user['phone'] ?>" target="_blank" class="btn btn-sm btn-outline-success me-1 rounded-pill" title="Kirim pesan di WhatsApp"><i class="bi bi-whatsapp"></i></a>
                          <a onclick="return confirm('Apakah anda yakin akan menghapus data dengan nama <?= $user['first_name'];?> ?')" href="../controllers/controller.php?deleteUser=<?= $user['user_id']; ?>" type="button" class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="tooltip" title="Delete"><i class="bi bi-trash"></i></a>
                        </div>
                      </td>                    
                    </tr>
                    
                    <!-- Modal for editing user -->
                    <div class="modal fade" id="editModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $user['user_id'] ?>" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header brand-bg-color text-white">
                            <h5 class="modal-title" id="editModalLabel<?= $user['user_id'] ?>"><i class="bi bi-pencil-square me-2"></i>Edit Data Mitra</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="../controllers/controller.php" method="POST">
                              <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                              
                              <!-- First Name Field -->
                              <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" value="<?= $user['first_name'] ?>" required>
                              </div>
                              
                              <!-- Last Name Field -->
                              <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" value="<?= $user['last_name'] ?>" required>
                              </div>
                              
                              <!-- Username Field -->
                              <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
                              </div>
                              
                              <!-- Email Field -->
                              <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                              </div>
                              
                              <!-- Phone Field -->
                              <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?>" required>
                              </div>
                              
                              <!-- Password Field (Optional) -->
                              <div class="mb-3">
                                <label for="password" class="form-label">Password (leave blank if no change)</label>
                                <input type="password" class="form-control" id="password" name="password">
                              </div>
                              
                              <!-- Modal Footer with Submit Button -->
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="updateMitra" class="btn btn-primary brand-bg-color">Save Changes</button>
                              </div>
                            </form>
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
  </script>

</body>

</html>