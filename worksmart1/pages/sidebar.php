  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar brand-bg-color-secondary">

    <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item mt-2 d-flex justify-content-center">
      &nbsp;
      &nbsp;
      &nbsp;
      &nbsp;
      &nbsp;
      &nbsp;
      <a class="nav-link collapsed text-center ml-4">
        <img src="assets/img/logo-worksmart.png" alt="logo" width="30">
        <span>Worksmart</span>
      </a>
    </li>
    <hr>
      
    <?php if($_SESSION['role'] == 'admin'): ?>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="data-mitra.php">
            <i class="bi bi-person-video3"></i>
            <span>Mentor</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="data-peserta.php">
            <i class="bi bi-people"></i>
            <span>Peserta</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="data-keuangan.php">
            <i class="bi bi-cash-coin"></i>
            <span>Keuangan</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#laporan-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="laporan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="laporan.php?kategori=Keuangan">
                <i class="bi bi-circle"></i><span>Keuangan</span>
              </a>
            </li>
            <li>
              <a href="laporan.php?kategori=Mitra">
                <i class="bi bi-circle"></i><span>Mitra</span>
              </a>
            </li>
            <li>
              <a href="laporan.php?kategori=Peserta">
                <i class="bi bi-circle"></i><span>Peserta</span>
              </a>
            </li>
          </ul>
        </li>

        <!-- <li class="nav-item">
          <a class="nav-link collapsed" href="mitra.php">
            <i class="bi bi-building"></i>
            <span>Mitra</span>
          </a>
        </li> -->

        <li class="nav-item">
          <a class="nav-link collapsed" href="kalender.php">
            <i class="bi bi-calendar3"></i>
            <span>Kalender</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link collapsed" href="pesan.php">
            <i class="bi bi-envelope"></i>
            <span>Pesan</span>
          </a>
        </li>

      <?php elseif($_SESSION['role'] == 'user'): ?>
        <!-- Menu untuk peserta -->
        <li class="nav-item">
                  <a class="nav-link collapsed" href="dashboard.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="data-pembayaran.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Pembayaran</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="aktivitas.php">
                    <i class="bi bi-activity"></i>
                    <span>Aktivitas</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="rating.php">
                    <i class="bi bi-star"></i>
                    <span>Rating/Ulasan</span>
                  </a>
                </li>
        
              <!--  <li class="nav-item">
                  <a class="nav-link collapsed" href="pesan.php">
                    <i class="bi bi-envelope"></i>
                    <span>Pesan</span>
                  </a>
                </li> -->
        
      <?php elseif($_SESSION['role'] == 'mitra'): ?>
                <!-- Menu untuk mitra -->
                <li class="nav-item">
                  <a class="nav-link collapsed" href="dashboard.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="data-workshop.php">
                    <i class="bi bi-easel"></i>
                    <span>Workshop</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="data-workshop.php">
                    <i class="bi bi-plus-square"></i>
                    <span>Buat Workshop Baru</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" data-bs-target="#laporan-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-text"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                  </a>
                  <ul id="laporan-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                      <a href="laporan.php?kategori=Peserta">
                        <i class="bi bi-circle"></i><span>Peserta</span>
                      </a>
                    </li>
                    <li>
                      <a href="laporan.php?kategori=Keuangan">
                        <i class="bi bi-circle"></i><span>Keuangan</span>
                      </a>
                    </li>
                  </ul>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="kalender.php">
                    <i class="bi bi-calendar3"></i>
                    <span>Kalender</span>
                  </a>
                </li>
        
                <li class="nav-item">
                  <a class="nav-link collapsed" href="pesan.php">
                    <i class="bi bi-envelope"></i>
                    <span>Pesan</span>
                  </a>
                </li>      
      <?php endif; ?>
    </ul>

  </aside>
  <!-- End Sidebar-->