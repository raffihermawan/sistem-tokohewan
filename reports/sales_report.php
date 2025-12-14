<?php
$title='Sales Report';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_login();

$start_date = $_GET['start_date'] ?? date('Y-m-01');
$end_date = $_GET['end_date'] ?? date('Y-m-d');

$stmt = $pdo->prepare('SELECT s.*,c.name as customer_name FROM sales s LEFT JOIN customers c ON s.customer_id=c.id WHERE DATE(s.created_at) BETWEEN ? AND ? ORDER BY s.id DESC');
$stmt->execute([$start_date, $end_date]);
$sales = $stmt->fetchAll();

$total_sales = 0;
foreach($sales as $s) $total_sales += $s['total'];
?>
<div class="container-fluid">
  <h3>Sales Report</h3>
  <form method="get" class="mb-3">
    <div class="row">
      <div class="col-md-3">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" value="<?php echo $start_date; ?>">
      </div>
      <div class="col-md-3">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" value="<?php echo $end_date; ?>">
      </div>
      <div class="col-md-3 align-self-end">
        <button class="btn btn-primary">Filter</button>
      </div>
    </div>
  </form>

  <p><strong>Total Sales: Rp <?php echo number_format($total_sales,0,',','.'); ?></strong></p>
  <table class="table">
    <thead><tr><th>Invoice</th><th>Customer</th><th>Total</th><th>Date</th></tr></thead>
    <tbody>
      <?php foreach($sales as $s): ?>
        <tr>
          <td><?php echo e($s['invoice']); ?></td>
          <td><?php echo e($s['customer_name']); ?></td>
          <td><?php echo number_format($s['total'],0,',','.'); ?></td>
          <td><?php echo date('d-m-Y', strtotime($s['created_at'])); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
