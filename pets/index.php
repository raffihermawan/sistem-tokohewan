<?php
$title='Pets';
require_once __DIR__ . '/../init.php';
require_login();

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';

$stmt = $pdo->query('SELECT * FROM pets ORDER BY id DESC');
$pets = $stmt->fetchAll();
?>

<div class="container-fluid">
  <h3 class="mb-3">
    Pets 
    <a href="create.php" class="btn btn-sm btn-primary">Add</a>
  </h3>

  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Image</th>
        <th>Name</th>
        <th>Type</th>
        <th>Breed</th>
        <th>Price</th>
        <th>Stock</th>
        <th width="180">Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach($pets as $p): ?>
        <tr>
          <td><?php echo e($p['id']); ?></td>

          <!-- IMAGE THUMBNAIL -->
          <td>
            <?php if (!empty($p['image'])): ?>
              <img src="<?php echo base_url('uploads/pets/' . $p['image']); ?>" 
                   class="img-thumbnail" 
                   style="width:60px; height:60px; object-fit:cover; border-radius:6px;">
            <?php else: ?>
              <span class="text-muted small">No image</span>
            <?php endif; ?>
          </td>

          <td><?php echo e($p['name']); ?></td>
          <td><?php echo e($p['type']); ?></td>
          <td><?php echo e($p['breed']); ?></td>

          <td>Rp <?php echo number_format($p['price'],0,',','.'); ?></td>

          <td><?php echo e($p['stock']); ?></td>

          <td>
            <a href="view.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-info">View</a>
            <a href="edit.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $p['id']; ?>" 
               class="btn btn-sm btn-danger btn-delete"
               data-id="<?php echo $p['id']; ?>">
               Delete
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
