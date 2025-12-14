<?php
require_once __DIR__ . '/../init.php';
require_login();

$title = "My Profile";

// Ambil data user dari session
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Load template
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
  <h3>My Profile</h3>

  <form action="update_profile.php" method="post" class="mt-3">

    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" 
             value="<?php echo e($user['name']); ?>" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control"
             value="<?php echo e($user['email']); ?>" required>
    </div>

    <div class="mb-3">
      <label>New Password <span class="text-muted">(optional)</span></label>
      <input type="password" name="password" class="form-control" placeholder="Leave blank if not changing">
    </div>

    <button class="btn btn-primary">Save Changes</button>
  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>

<!-- SWEETALERT FLASH -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (!empty($_SESSION['profile_success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Profile Updated',
    text: 'Profil berhasil diperbarui.',
});
</script>
<?php unset($_SESSION['profile_success']); endif; ?>

<?php if (!empty($_SESSION['profile_error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Update Failed',
    text: '<?php echo $_SESSION['profile_error']; ?>',
});
</script>
<?php unset($_SESSION['profile_error']); endif; ?>
