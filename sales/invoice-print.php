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
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice <?php echo e($sale['invoice']); ?></title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
<h2>Invoice</h2>
<p><strong>Invoice No:</strong> <?php echo e($sale['invoice']); ?></p>
<p><strong>Customer:</strong> <?php echo e($sale['customer_name']); ?></p>
<p><strong>Date:</strong> <?php echo date('d-m-Y H:i', strtotime($sale['created_at'])); ?></p>

<table>
  <tr><th>Pet</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
  <?php foreach($items as $item): ?>
    <tr>
      <td><?php echo e($item['pet_name']); ?></td>
      <td><?php echo $item['qty']; ?></td>
      <td>Rp <?php echo number_format($item['price'],0,',','.'); ?></td>
      <td>Rp <?php echo number_format($item['subtotal'],0,',','.'); ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<p><strong>Total: Rp <?php echo number_format($sale['total'],0,',','.'); ?></strong></p>

<script>window.print();</script>
</body>
</html>
