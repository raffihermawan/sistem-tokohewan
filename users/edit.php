<?php
$title='Edit User';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
require_role('admin');

$id = $_GET['id'] ?? null; if (!$id) header('Location: index.php');
$stmt = $pdo->prepare('SELECT * FROM users WHERE id=?'); $stmt->execute([$id]); $u = $stmt->fetch();
if (!$u) header('Location: index.php');
$err=null;
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $name=clean_input($_POST['name']??'');
    $email=clean_input($_POST['email']??'');
    $role=in_array($_POST['role']??'kasir',['admin','kasir','owner'])?$_POST['role']:'kasir';
    $password=$_POST['password']??'';
    if($name && $email){
        if($password){
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $stmt=$pdo->prepare('UPDATE users SET name=?,email=?,password=?,role=? WHERE id=?');
            $stmt->execute([$name,$email,$hash,$role,$id]);
        } else {
            $stmt=$pdo->prepare('UPDATE users SET name=?,email=?,role=? WHERE id=?');
            $stmt->execute([$name,$email,$role,$id]);
        }
        header('Location: index.php'); exit;
    } else $err='Fill required fields';
}
?>
<div class="container-fluid">
  <h3>Edit User</h3>
  <?php if($err): ?><div class="alert alert-danger"><?php echo e($err); ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label>Name</label><input name="name" class="form-control" value="<?php echo e($u['name']); ?>" required></div>
    <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" value="<?php echo e($u['email']); ?>" required></div>
    <div class="mb-3"><label>New Password (leave blank to keep)</label><input name="password" type="password" class="form-control"></div>
    <div class="mb-3"><label>Role</label><select name="role" class="form-select"><option value="admin" <?php if($u['role']==='admin') echo 'selected'; ?>>Admin</option><option value="kasir" <?php if($u['role']==='kasir') echo 'selected'; ?>>Kasir</option><option value="owner" <?php if($u['role']==='owner') echo 'selected'; ?>>Owner</option></select></div>
    <button class="btn btn-primary">Update</button>
  </form>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
