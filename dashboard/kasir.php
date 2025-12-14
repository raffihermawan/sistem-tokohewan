<?php
$title='Kasir Dashboard';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_role('kasir');

$stmt = $pdo->query('SELECT COUNT(*) as cnt FROM sales');
$total_transactions = $stmt->fetch()['cnt'];
$stmt = $pdo->query('SELECT COUNT(*) as cnt FROM customers');
$total_customers = $stmt->fetch()['cnt'];
$stmt = $pdo->query('SELECT SUM(total) as total FROM sales');
$total_sales = $stmt->fetch()['total'] ?? 0;
?>
<div class="container-fluid p-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="fw-bold" style="color: #2c3e50;">
        <i class="fas fa-cash-register me-2" style="color: #3498db;"></i> Kasir Dashboard
      </h2>
      <p class="text-muted small">Process sales and manage transactions.</p>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card text-white bg-primary animate-slideIn">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Transactions</h6>
              <h3 class="fw-bold"><?php echo $total_transactions; ?></h3>
            </div>
            <i class="fas fa-receipt fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-check me-1"></i> Today</small>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card text-white bg-success animate-slideIn" style="animation-delay: 0.1s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Revenue</h6>
              <h3 class="fw-bold">Rp <?php echo number_format($total_sales,0,',','.'); ?></h3>
            </div>
            <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-arrow-up me-1"></i> Income</small>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card text-white bg-info animate-slideIn" style="animation-delay: 0.2s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Customers</h6>
              <h3 class="fw-bold"><?php echo $total_customers; ?></h3>
            </div>
            <i class="fas fa-users fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-check me-1"></i> Registered</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Action -->
  <div class="row g-3">
    <div class="col-12 col-sm-6 col-lg-4">
      <a href="<?php echo base_url('sales/create.php'); ?>" class="btn btn-success btn-lg w-100 shadow-md">
        <i class="fas fa-shopping-cart me-2"></i> Create New Sale
      </a>
    </div>
  </div>
</div>

<script>
  document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
  });
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 768) document.getElementById('sidebar').classList.remove('show');
    });
  });
</script>

<?php require_once __DIR__ . '/../templates/footer.php';
