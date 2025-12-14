<?php
$title='Owner Dashboard';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_role('owner');

$stmt = $pdo->query('SELECT SUM(total) as total FROM sales');
$total_sales = $stmt->fetch()['total'] ?? 0;
$stmt = $pdo->query('SELECT SUM(stock*price) as total_value FROM pets');
$total_inventory = $stmt->fetch()['total_value'] ?? 0;
$stmt = $pdo->query('SELECT COUNT(*) as cnt FROM sales');
$total_transactions = $stmt->fetch()['cnt'];
?>
<div class="container-fluid p-4">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="fw-bold" style="color: #2c3e50;">
        <i class="fas fa-crown me-2" style="color: #f39c12;"></i> Owner Dashboard
      </h2>
      <p class="text-muted small">Business overview and financial reports.</p>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card text-white bg-success animate-slideIn">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Revenue</h6>
              <h3 class="fw-bold">Rp <?php echo number_format($total_sales,0,',','.'); ?></h3>
            </div>
            <i class="fas fa-chart-line fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-arrow-up me-1"></i> Income</small>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card text-white bg-warning animate-slideIn" style="animation-delay: 0.1s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Inventory Value</h6>
              <h3 class="fw-bold">Rp <?php echo number_format($total_inventory,0,',','.'); ?></h3>
            </div>
            <i class="fas fa-boxes fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-check me-1"></i> In Stock</small>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card text-white bg-info animate-slideIn" style="animation-delay: 0.2s;">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <h6 class="card-title text-uppercase text-white-50 small fw-bold">Total Transactions</h6>
              <h3 class="fw-bold"><?php echo $total_transactions; ?></h3>
            </div>
            <i class="fas fa-receipt fa-2x opacity-50"></i>
          </div>
          <small class="d-block mt-2"><i class="fas fa-check me-1"></i> Completed</small>
        </div>
      </div>
    </div>
  </div>

  <!-- Reports Section -->
  <div class="row g-3">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i> Available Reports</h6>
        </div>
        <div class="card-body">
          <div class="row g-2">
            <div class="col-12 col-sm-6 col-md-4">
              <a href="<?php echo base_url('reports/sales_report.php'); ?>" class="btn btn-outline-primary w-100">
                <i class="fas fa-chart-bar me-2"></i> Sales Report
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <a href="<?php echo base_url('reports/stock_report.php'); ?>" class="btn btn-outline-success w-100">
                <i class="fas fa-cube me-2"></i> Stock Report
              </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <a href="<?php echo base_url('reports/customer_report.php'); ?>" class="btn btn-outline-info w-100">
                <i class="fas fa-users me-2"></i> Customer Report
              </a>
            </div>
          </div>
        </div>
      </div>
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
