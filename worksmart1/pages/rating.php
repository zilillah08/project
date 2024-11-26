<?php
require '../controllers/function.php';
checkAuth();
$purchasedWorkshops = getPurchasedWorkshops($_SESSION['user_id']);

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
      <h1 class="text-light">Data Rating</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Data Rating</li>
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
              <h5 class="card-title">Rating Workshop</h5>
              <p class="text-dark">Berikut adalah daftar workshop yang telah diselesaikan.</p>
              <a href="#" onclick="location.reload();" class="brand-btn btn mt-2 mb-4 rounded-pill"><i class="bi bi-arrow-clockwise me-2"></i>Refresh</a>              
              
            <!-- Fetch Data Workshop dari db -->
            <div class="table-responsive">
              <table class="table table-striped table-hover dt-responsive nowrap" id="participantTable" style="width:100%">

              <thead>
              <tr>
                  <th>Workshop Title</th>
                  <th>Current Rating</th>
                  <th>Your Review</th>
                  <th>Actions</th>
              </tr>
              </thead>
              <tbody>
              <?php 
              foreach($purchasedWorkshops as $workshop) { ?>
                  <tr>
                      <td><?= $workshop['title'] ?></td>
                      <td>
                          <?php if($workshop['user_rating']): ?>
                              <?= str_repeat('★', $workshop['user_rating']) ?>
                          <?php else: ?>
                              <span class="text-muted">Not rated yet</span>
                          <?php endif; ?>
                      </td>
                      <td><?= $workshop['comment'] ?? 'No review yet' ?></td>
                      <td>
                          <?php if($workshop['user_rating']): ?>
                              <!-- Edit Rating Button -->
                              <button type="button" 
                                      class="btn btn-sm btn-outline-warning me-1 rounded-pill" 
                                      data-bs-toggle="modal" 
                                      data-bs-target="#editRating<?= $workshop['workshop_id'] ?>" 
                                      title="Edit Rating">
                                  <i class="bi bi-pencil-square"></i>
                              </button>

                              <div class="modal fade" id="editRating<?= $workshop['workshop_id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title brand-color">Edit Rating: <?= $workshop['title'] ?></h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="../controllers/controller.php" method="POST">
                                      <div class="modal-body">
                                        <input type="hidden" name="feedback_id" value="<?= $workshop['feedback_id'] ?>">
                                        <div class="mb-3">
                                          <label class="form-label">Rating</label>
                                          <select name="rating" class="form-select" required>
                                            <?php for($i=1; $i<=5; $i++): ?>
                                              <option value="<?= $i ?>" <?= ($workshop['user_rating'] == $i) ? 'selected' : '' ?>>
                                                <?= str_repeat('★', $i) ?>
                                              </option>
                                            <?php endfor; ?>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label class="form-label">Review</label>
                                          <textarea name="comment" class="form-control" rows="3" required><?= $workshop['comment'] ?></textarea>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="editRating" class="btn brand-btn">Update Rating</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>

                          <?php else: ?>
                              <!-- Add Rating Button -->
                              <button type="button" 
                                      class="btn btn-sm btn-outline-primary me-1 rounded-pill" 
                                      data-bs-toggle="modal" 
                                      data-bs-target="#addRating<?= $workshop['workshop_id'] ?>" 
                                      title="Add Rating">
                                  <i class="bi bi-plus-circle"></i>
                              </button>

                                <!-- Add Rating Modal -->
                                <div class="modal fade" id="addRating<?= $workshop['workshop_id'] ?>" tabindex="-1">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Rate Workshop: <?= $workshop['title'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <form action="../controllers/controller.php" method="POST">
                                        <div class="modal-body">
                                          <input type="hidden" name="workshop_id" value="<?= $workshop['workshop_id'] ?>">
                                          <div class="mb-3">
                                            <label class="form-label">Rating</label>
                                            <select name="rating" class="form-select" required>
                                              <option value="">Select rating</option>
                                              <?php for($i=1; $i<=5; $i++): ?>
                                                <option value="<?= $i ?>"><?= str_repeat('★', $i) ?></option>
                                              <?php endfor; ?>
                                            </select>
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label">Review</label>
                                            <textarea name="comment" class="form-control" rows="3" required></textarea>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" name="addRating" class="btn brand-btn">Submit Rating</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>


                          <?php endif; ?>
                      </td>
                  </tr>
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