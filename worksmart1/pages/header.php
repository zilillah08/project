  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
  
    <div class="d-flex align-items-center justify-content-between">
      <a href="home.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo-worksmart.png" alt="">
        <span class="d-none d-lg-block">WorkSmart</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <!-- End Search Bar -->
    <div class="ms-3 d-flex justify-content-center">
        <a href="home.php" class="btn btn-sm btn-outline-dark rounded-pill">
          <i class="bi bi-house-door"></i>
        </a>
   </div>     

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <?php
          if($_SESSION['role']=='admin'){
          $notifications = getNotifications($_SESSION['user_id']);
          $notif_count = count($notifications);
          ?>

          <li class="nav-item dropdown">
              <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                  <i class="bi bi-bell"></i>
                  <span class="badge bg-primary badge-number"><?= $notif_count ?></span>
              </a>

              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                  <li class="dropdown-header">
                      You have <?= $notif_count ?> new notifications
                      <a href="data-keuangan.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                  </li>
                  
                  <?php foreach($notifications as $notif): ?>
                      <li>
                          <hr class="dropdown-divider">
                      </li>
                      <li class="notification-item">
                          <i class="bi bi-exclamation-circle text-warning"></i>
                          <div>
                              <h4 class="brand-color">New Pending Payment</h4>
                              <p><?= $notif['user_name'] ?> - <?= $notif['workshop_title'] ?></p>
                              <?php
                              if($notif['minutes_ago'] < 60) {
                                  echo "<p>{$notif['minutes_ago']} min. ago</p>";
                              } else if($notif['minutes_ago'] < 1440) {
                                  $hours = floor($notif['minutes_ago']/60);
                                  echo "<p>{$hours} hr. ago</p>";
                              } else {
                                  $days = floor($notif['minutes_ago']/1440);
                                  echo "<p>{$days} days ago</p>";
                              }
                              ?>
                          </div>
                      </li>
                  <?php endforeach; ?>

                  <li>
                      <hr class="dropdown-divider">
                  </li>
                  <li class="dropdown-footer">
                      <a href="data-keuangan.php">Show all notifications</a>
                  </li>
              </ul>
          </li>
          <?php } ?>
        <!-- End Notification Nav -->

      <!--  <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number message-count">0</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header message-header">
              You have <span class="unread-count">0</span> new messages
              <a href="pesan.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li><hr class="dropdown-divider"></li>

            Messages will be inserted here dynamically 
            <div class="message-items"></div>

            <li><hr class="dropdown-divider"></li>
            <li class="dropdown-footer">
              <a href="pesan.php">Show all messages</a>
            </li>
          </ul> 
        </li> -->
        <!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= ucfirst($_SESSION['first_name']);?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= ucfirst($_SESSION['first_name']);?></h6>
              <span><?= ucfirst($_SESSION['role']);?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profil.php">
                <i class="bi bi-gear"></i>
                <span>Setting akun</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../controllers/controller.php?logout=true">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header>
  <!-- End Header -->
