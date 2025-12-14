<?php
require_once __DIR__ . '/../init.php';

if (is_logged_in()) {
    header('Location: ' . BASE_URL . '/dashboard/index.php');
    exit;
}

// FLASH MESSAGE LOGOUT
$logout_success = $_SESSION['logout_success'] ?? null;
unset($_SESSION['logout_success']);

$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        // set session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email']= $user['email'];
        $_SESSION['user_role'] = $user['role'];

        // redirect by role
        if ($user['role'] === 'admin') {
            header('Location: ' . BASE_URL . '/dashboard/admin.php');
        } elseif ($user['role'] === 'kasir') {
            header('Location: ' . BASE_URL . '/dashboard/kasir.php');
        } elseif ($user['role'] === 'owner') {
            header('Location: ' . BASE_URL . '/dashboard/owner.php');
        } else {
            header('Location: ' . BASE_URL . '/dashboard/index.php');
        }
        exit;

    } else {
        $err = 'Email atau password salah.';
    }
}

require_once __DIR__ . '/../templates/header.php';
?>

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">

          <!-- =========================
               LOGO ICON KUCING
          ========================== -->
          <div class="text-center mb-4">
            <div style="
                width:120px;
                height:120px;
                margin:auto;
                border-radius:50%;
                background:white;
                overflow:hidden;
                display:flex;
                align-items:center;
                justify-content:center;
                box-shadow:0 4px 12px rgba(0,0,0,0.15);
            ">
                <i class="fas fa-cat" 
                   style="font-size:65px; color:#ff9900;"></i>
            </div>
          </div>

          <h4 class="card-title mb-3 text-center">Login</h4>

          <!-- FORM LOGIN -->
          <form method="post" action="">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100">Login</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>

<!-- =======================================
     SWEETALERT HANDLING
======================================= -->

<?php if (!empty($logout_success)): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Logout berhasil',
    text: 'Anda telah keluar dari sistem.',
    confirmButtonColor: '#3085d6'
});
</script>
<?php endif; ?>

<?php if (!empty($err)): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Login gagal',
    text: '<?php echo $err; ?>',
    confirmButtonColor: '#d33'
});
</script>
<?php endif; ?>
