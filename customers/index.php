<?php
$title='Customers';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_login();

// Fetch customers
$stmt = $pdo->query('SELECT * FROM customers ORDER BY id DESC');
$customers = $stmt->fetchAll();
?>
<div class="container-fluid">
  <h3>Customers <a href="create.php" class="btn btn-sm btn-primary">Add</a></h3>
  <table class="table table-striped">
    <thead><tr><th>#</th><th>Name</th><th>Phone</th><th>Email</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach($customers as $c): ?>
        <tr>
          <td><?php echo e($c['id']); ?></td>
          <td><?php echo e($c['name']); ?></td>
          <td><?php echo e($c['phone']); ?></td>
          <td><?php echo e($c['email']); ?></td>
          <td>
            <a href="view.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-info">View</a>
            <a href="edit.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
