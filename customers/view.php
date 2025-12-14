<?php
require_once __DIR__ . '/../init.php';
require_login();
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM customers WHERE id=?');
$stmt->execute([$id]);
$c = $stmt->fetch();
if (!$c) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>
<div class="container-fluid">
  <h3>Customer Detail</h3>
  <table class="table">
    <tr><th>Name</th><td><?php echo e($c['name']); ?></td></tr>
    <tr><th>Phone</th><td><?php echo e($c['phone']); ?></td></tr>
    <tr><th>Email</th><td><?php echo e($c['email']); ?></td></tr>
    <tr><th>Address</th><td><?php echo e($c['address']); ?></td></tr>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
