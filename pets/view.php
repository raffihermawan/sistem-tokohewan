<?php
require_once __DIR__ . '/../init.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM pets WHERE id=?");
$stmt->execute([$id]);
$pet = $stmt->fetch();

if (!$pet) { header("Location: index.php"); exit; }

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
  <h3>Pet Details</h3>

  <div class="card p-3" style="max-width: 500px;">
    <?php if ($pet['image']): ?>
      <img src="<?php echo base_url('uploads/pets/' . $pet['image']); ?>"
           class="img-fluid rounded mb-3"
           style="width:100%; max-height:300px; object-fit:cover;">
    <?php else: ?>
      <p class="text-muted">No image uploaded.</p>
    <?php endif; ?>

    <p><strong>Name:</strong> <?php echo e($pet['name']); ?></p>
    <p><strong>Type:</strong> <?php echo e($pet['type']); ?></p>
    <p><strong>Breed:</strong> <?php echo e($pet['breed']); ?></p>
    <p><strong>Age:</strong> <?php echo e($pet['age']); ?></p>
    <p><strong>Price:</strong> Rp <?php echo number_format($pet['price'],0,',','.'); ?></p>
    <p><strong>Stock:</strong> <?php echo e($pet['stock']); ?></p>

    <a href="index.php" class="btn btn-secondary mt-2">Back</a>
  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
