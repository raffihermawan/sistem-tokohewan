<?php
$title='Add User';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_role('admin');

$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = in_array($_POST['role'] ?? 'kasir', ['admin','kasir','owner']) ? $_POST['role'] : 'kasir';
    if ($name && $email && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
        $stmt->execute([$name,$email,$hash,$role]);
        header('Location: index.php'); exit;
    } else $err='Fill all fields';
}
?>
<div class="container-fluid">
  <h3>Add User</h3>
  <?php if($err): ?><div class="alert alert-danger"><?php echo e($err); ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label>Name</label><input name="name" class="form-control" required></div>
    <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
    <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
    <div class="mb-3"><label>Role</label><select name="role" class="form-select"><option value="admin">Admin</option><option value="kasir" selected>Kasir</option><option value="owner">Owner</option></select></div>
    <button class="btn btn-primary">Save</button>
  </form>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
