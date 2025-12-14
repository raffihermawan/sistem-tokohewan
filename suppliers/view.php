<?php
require_once __DIR__ . '/../init.php';
require_login();
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM suppliers WHERE id=?');
$stmt->execute([$id]);
$s = $stmt->fetch();
if (!$s) { header('Location: index.php'); exit; }
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>
<div class="container-fluid">
  <h3>Supplier Detail</h3>
  <table class="table">
    <tr><th>Name</th><td><?php echo e($s['name']); ?></td></tr>
    <tr><th>Phone</th><td><?php echo e($s['phone']); ?></td></tr>
    <tr><th>Email</th><td><?php echo e($s['email']); ?></td></tr>
    <tr><th>Address</th><td><?php echo e($s['address']); ?></td></tr>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
