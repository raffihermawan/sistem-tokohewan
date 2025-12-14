<?php
require_once __DIR__ . '/../init.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT s.*,c.name as customer_name FROM sales s LEFT JOIN customers c ON s.customer_id=c.id WHERE s.id=?');
$stmt->execute([$id]);
$sale = $stmt->fetch();
if (!$sale) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT si.*,p.name as pet_name FROM sales_items si JOIN pets p ON si.pet_id=p.id WHERE si.sale_id=?');
$stmt->execute([$id]);
$items = $stmt->fetchAll();

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>
<div class="container-fluid">
  <h3>Invoice</h3>
  <div class="row">
    <div class="col-md-6">
      <p><strong>Invoice:</strong> <?php echo e($sale['invoice']); ?></p>
      <p><strong>Customer:</strong> <?php echo e($sale['customer_name']); ?></p>
      <p><strong>Date:</strong> <?php echo date('d-m-Y H:i', strtotime($sale['created_at'])); ?></p>
    </div>
  </div>
  <table class="table">
    <thead><tr><th>Pet</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
    <tbody>
      <?php foreach($items as $item): ?>
        <tr>
          <td><?php echo e($item['pet_name']); ?></td>
          <td><?php echo $item['qty']; ?></td>
          <td><?php echo number_format($item['price'],0,',','.'); ?></td>
          <td><?php echo number_format($item['subtotal'],0,',','.'); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <p><strong>Total: Rp <?php echo number_format($sale['total'],0,',','.'); ?></strong></p>
  <a href="invoice-print.php?id=<?php echo $id; ?>" class="btn btn-primary" target="_blank">Print</a>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
