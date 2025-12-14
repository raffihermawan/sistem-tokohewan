<?php
$title='Stock Report';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_login();

$stmt = $pdo->query('SELECT * FROM pets ORDER BY stock ASC');
$pets = $stmt->fetchAll();
?>
<div class="container-fluid">
  <h3>Stock Report</h3>
  <table class="table">
    <thead><tr><th>#</th><th>Pet Name</th><th>Type</th><th>Stock</th><th>Price</th><th>Total Value</th></tr></thead>
    <tbody>
      <?php $total_value = 0; foreach($pets as $p): 
        $value = $p['stock'] * $p['price'];
        $total_value += $value;
      ?>
        <tr>
          <td><?php echo e($p['id']); ?></td>
          <td><?php echo e($p['name']); ?></td>
          <td><?php echo e($p['type']); ?></td>
          <td><?php echo e($p['stock']); ?></td>
          <td><?php echo number_format($p['price'],0,',','.'); ?></td>
          <td><?php echo number_format($value,0,',','.'); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p><strong>Total Stock Value: Rp <?php echo number_format($total_value,0,',','.'); ?></strong></p>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
