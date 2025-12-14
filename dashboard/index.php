<?php
$title = 'Dashboard';
require_once __DIR__ . '/../init.php';

require_login();

// Redirect ke dashboard sesuai role
$user = current_user();
$role = $user['role'] ?? null;

if ($role === 'admin') {
    header('Location: ' . BASE_URL . '/dashboard/admin.php');
} elseif ($role === 'kasir') {
    header('Location: ' . BASE_URL . '/dashboard/kasir.php');
} elseif ($role === 'owner') {
    header('Location: ' . BASE_URL . '/dashboard/owner.php');
} else {
    // Role tidak dikenali, tampilkan pesan
    require_once __DIR__ . '/../templates/header.php';
    require_once __DIR__ . '/../templates/topbar.php';
    require_once __DIR__ . '/../templates/sidebar.php';
?>
<div class="container-fluid p-4">
  <div class="alert alert-danger" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i> <strong>Akses Ditolak</strong>
    <p>Role Anda tidak dikenali oleh sistem. Hubungi administrator untuk bantuan.</p>
  </div>
</div>
<?php
    require_once __DIR__ . '/../templates/footer.php';
}
?>
