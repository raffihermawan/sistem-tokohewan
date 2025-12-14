<?php
require_once __DIR__ . '/../init.php';

$err = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = in_array($_POST['role'] ?? 'kasir', ['admin','kasir','owner']) ? $_POST['role'] : 'kasir';

    if ($name && $email && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
        try {
            $stmt->execute([$name,$email,$hash,$role]);
            header('Location: ' . BASE_URL . '/auth/login.php');
            exit;
        } catch (PDOException $e) {
            $err = 'Gagal mendaftar: ' . $e->getMessage();
        }
    } else {
        $err = 'Lengkapi semua kolom.';
    }
}

require_once __DIR__ . '/../templates/header.php';
?>
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Register</h4>
          <?php if($err): ?>
            <div class="alert alert-danger"><?php echo e($err); ?></div>
          <?php endif; ?>
          <form method="post" action="">
            <div class="mb-3">
              <label>Nama</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Role</label>
              <select name="role" class="form-select">
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
                <option value="owner">Owner</option>
              </select>
            </div>
            <button class="btn btn-success">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../templates/footer.php';
