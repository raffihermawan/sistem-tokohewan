<?php
$title='Admin Dashboard';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_role('admin');

$stmt = $pdo->query('SELECT COUNT(*) as cnt FROM customers');
$total_customers = $stmt->fetch()['cnt'];
$stmt = $pdo->query('SELECT COUNT(*) as cnt FROM pets');
$total_pets = $stmt->fetch()['cnt'];
$stmt = $pdo->query('SELECT COUNT(*) as cnt FROM users');
$total_users = $stmt->fetch()['cnt'];
$stmt = $pdo->query('SELECT SUM(total) as total FROM sales');
$total_sales = $stmt->fetch()['total'] ?? 0;
?>
<div class="container-fluid p-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="fw-bold" style="color: #2c3e50;">
        <i class="fas fa-chart-line me-2" style="color: #3498db;"></i> Admin Dashboard
      </h2>
      <p class="text-muted small">Welcome back! Here's an overview of your petshop.</p>
    </div>
  </div>

  <!-- Stats Cards Row -->
  <div class="row g-3 mb-4">
    <!-- Total Customers Card -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card text-white bg-primary animate-slideIn">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Customers</h6>
              <h3 class="fw-bold"><?php echo $total_customers; ?></h3>
            </div>
            <i class="fas fa-users fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-arrow-up me-1"></i> Active customers</small>
        </div>
      </div>
    </div>

    <!-- Total Pets Card -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card text-white bg-success animate-slideIn" style="animation-delay: 0.1s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Pets</h6>
              <h3 class="fw-bold"><?php echo $total_pets; ?></h3>
            </div>
            <i class="fas fa-paw fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-arrow-up me-1"></i> Registered</small>
        </div>
      </div>
    </div>

    <!-- Total Users Card -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card text-white bg-warning animate-slideIn" style="animation-delay: 0.2s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Users</h6>
              <h3 class="fw-bold"><?php echo $total_users; ?></h3>
            </div>
            <i class="fas fa-user-shield fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-check me-1"></i> Active users</small>
        </div>
      </div>
    </div>

    <!-- Total Sales Card -->
    <div class="col-12 col-sm-6 col-lg-3">
      <div class="card text-white bg-info animate-slideIn" style="animation-delay: 0.3s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Sales</h6>
              <h3 class="fw-bold">Rp <?php echo number_format($total_sales,0,',','.'); ?></h3>
            </div>
            <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-chart-bar me-1"></i> Revenue</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions Row -->
  <div class="row g-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0"><i class="fas fa-lightning-bolt me-2"></i> Quick Actions</h6>
        </div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url('customers/create.php'); ?>" class="btn btn-primary w-100">
                <i class="fas fa-user-plus me-2"></i> Add Customer
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url('pets/create.php'); ?>" class="btn btn-success w-100">
                <i class="fas fa-paw me-2"></i> Add Pet
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url('sales/create.php'); ?>" class="btn btn-info w-100">
                <i class="fas fa-shopping-cart me-2"></i> New Sale
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
              <a href="<?php echo base_url('users/create.php'); ?>" class="btn btn-warning w-100">
                <i class="fas fa-user-shield me-2"></i> Add User
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Sidebar toggle for mobile
  document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
  });

  // Close sidebar when clicking on a link (mobile)
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 768) {
        document.getElementById('sidebar').classList.remove('show');
      }
    });
  });
</script>

<?php require_once __DIR__ . '/../templates/footer.php';
