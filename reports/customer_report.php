<?php
$title='Customer Report';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_login();

$stmt = $pdo->query('SELECT c.*,COUNT(s.id) as total_sales,SUM(s.total) as total_spent FROM customers c LEFT JOIN sales s ON c.id=s.customer_id GROUP BY c.id ORDER BY total_spent DESC');
$customers = $stmt->fetchAll();
?>
<div class="container-fluid">
  <h3>Customer Report</h3>
  <table class="table">
    <thead><tr><th>#</th><th>Name</th><th>Phone</th><th>Email</th><th>Total Transactions</th><th>Total Spent</th></tr></thead>
    <tbody>
      <?php foreach($customers as $c): ?>
        <tr>
          <td><?php echo e($c['id']); ?></td>
          <td><?php echo e($c['name']); ?></td>
          <td><?php echo e($c['phone']); ?></td>
          <td><?php echo e($c['email']); ?></td>
          <td><?php echo e($c['total_sales']); ?></td>
          <td><?php echo number_format($c['total_spent'],0,',','.'); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
