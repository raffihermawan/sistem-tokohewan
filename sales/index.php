<?php
$title='Sales';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_login();

$stmt = $pdo->query('SELECT s.*,c.name as customer_name FROM sales s LEFT JOIN customers c ON s.customer_id=c.id ORDER BY s.id DESC');
$sales = $stmt->fetchAll();
?>
<div class="container-fluid">
  <h3>Sales <a href="create.php" class="btn btn-sm btn-primary">New Sale</a></h3>
  <table class="table table-striped">
    <thead><tr><th>#</th><th>Invoice</th><th>Customer</th><th>Total</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach($sales as $s): ?>
        <tr>
          <td><?php echo e($s['id']); ?></td>
          <td><?php echo e($s['invoice']); ?></td>
          <td><?php echo e($s['customer_name']); ?></td>
          <td><?php echo number_format($s['total'],0,',','.'); ?></td>
          <td><?php echo date('d-m-Y', strtotime($s['created_at'])); ?></td>
          <td>
            <a href="invoice.php?id=<?php echo $s['id']; ?>" class="btn btn-sm btn-info">Invoice</a>
            <a href="invoice-print.php?id=<?php echo $s['id']; ?>" class="btn btn-sm btn-success">Print</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
