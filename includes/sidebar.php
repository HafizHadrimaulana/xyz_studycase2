<aside class="main-sidebar sidebar-dark-indigo elevation-4">
  <!-- Brand Logo -->
  <a href="/xyz_studycase2/index.php" class="brand-link text-center">
    <span class="brand-text font-weight-bold" style="font-size: 1.1rem;">XYZ SYSTEM</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User panel -->
    <div class="user-panel d-flex flex-column align-items-center justify-content-center mt-3 pb-3 mb-3 border-bottom text-center">
      <div class="info">
        <a href="#" class="d-block text-white"><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="/xyz_studycase2/index.php"
             class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Data Karyawan -->
        <li class="nav-item">
          <a href="/xyz_studycase2/pages/employees.php"
             class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'employees.php' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Data Karyawan</p>
          </a>
        </li>
        <!-- Divider -->
        <li class="nav-header">AKUN</li>
        <!-- Logout -->
        <li class="nav-item">
          <a href="/xyz_studycase2/logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt" style="color: #e60000;"></i>
            <p class="text-danger font-weight-bold">Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
