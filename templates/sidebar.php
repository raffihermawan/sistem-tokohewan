<?php
// ========================================
// PREVENT HEADER ERROR: AUTH CHECK FIRST
// ========================================

require_once __DIR__ . '/../init.php';

// Ambil data user sebelum HTML keluar
$user = current_user();

// Jika user tidak login, redirect sebelum HTML muncul
if (!$user) {
    header("Location: " . base_url("auth/login.php"));
    exit;
}
?>

<!-- HTML SIDEBAR MULAI DI SINI (AMAN) -->
<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <nav class="sidebar" id="sidebar">

    <div class="sidebar-header p-3 text-center border-bottom border-dark">
      <img src="<?php echo base_url('assets/images/logo.png'); ?>" 
           alt="logo" 
           class="mb-2" 
           style="height:50px; object-fit:contain;">
      <p class="text-muted small mb-0">Petshop Management</p>
    </div>

    <ul class="nav flex-column p-2">

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('dashboard/index.php'); ?>">
          <i class="fas fa-chart-line me-2"></i> <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('customers/index.php'); ?>">
          <i class="fas fa-users me-2"></i> <span>Customers</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('pets/index.php'); ?>">
          <i class="fas fa-paw me-2"></i> <span>Pets</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('suppliers/index.php'); ?>">
          <i class="fas fa-truck me-2"></i> <span>Suppliers</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('sales/index.php'); ?>">
          <i class="fas fa-shopping-cart me-2"></i> <span>Sales</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('inventory/index.php'); ?>">
          <i class="fas fa-boxes me-2"></i> <span>Inventory</span>
        </a>
      </li>

      <?php if ($user && $user['role'] === 'admin'): ?>
      <li class="nav-item border-top border-dark mt-3 pt-3">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('users/index.php'); ?>">
          <i class="fas fa-user-shield me-2"></i> <span>Users</span>
        </a>
      </li>
      <?php endif; ?>

      <li class="nav-item border-top border-dark mt-3 pt-3">
        <a class="nav-link d-flex align-items-center" 
           href="<?php echo base_url('reports/sales_report.php'); ?>">
          <i class="fas fa-file-alt me-2"></i> <span>Reports</span>
        </a>
      </li>

    </ul>

    <!-- User Footer -->
    <div class="sidebar-footer p-3 border-top border-dark mt-auto">
      <div class="d-flex align-items-center small">
        <div class="flex-grow-1">
          <p class="mb-0 text-white">
            <strong><?php echo e($user['name'] ?? 'Guest'); ?></strong>
          </p>
          <p class="mb-0 text-muted small">
            <?php echo ucfirst($user['role'] ?? 'guest'); ?>
          </p>
        </div>
      </div>
    </div>

  </nav>

  <!-- Main Content (dibuka di sidebar) -->
  <div class="main-content flex-fill">

    <!-- Sidebar Toggle Button (mobile) -->
    <button class="btn btn-sm btn-outline-secondary d-md-none position-fixed" 
            id="sidebarToggle" 
            style="top: 65px; left: 15px; z-index: 999;">
      <i class="fas fa-bars"></i>
    </button>
