<?php
$title='Users';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_role('admin');

$stmt = $pdo->query('SELECT * FROM users ORDER BY id DESC');
$users = $stmt->fetchAll();
?>
<div class="container-fluid">
  <h3>Users <a href="create.php" class="btn btn-sm btn-primary">Add</a></h3>
  <table class="table table-striped">
    <thead><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach($users as $u): ?>
        <tr>
          <td><?php echo e($u['id']); ?></td>
          <td><?php echo e($u['name']); ?></td>
          <td><?php echo e($u['email']); ?></td>
          <td><?php echo e($u['role']); ?></td>
          <td>
            <a href="edit.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
