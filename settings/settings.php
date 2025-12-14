<?php
require_once __DIR__ . '/../init.php';
require_login();

$title = "Settings";

// Ambil data settings
$stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
$settings = $stmt->fetch();

// Load template
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
  <h3>System Settings</h3>

  <form action="update_settings.php" method="post" class="mt-3">

    <div class="mb-3">
      <label>Shop Name</label>
      <input type="text" name="shop_name" class="form-control" 
             value="<?php echo e($settings['shop_name']); ?>" required>
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="shop_email" class="form-control"
             value="<?php echo e($settings['shop_email']); ?>">
    </div>

    <div class="mb-3">
      <label>Phone</label>
      <input type="text" name="shop_phone" class="form-control"
             value="<?php echo e($settings['shop_phone']); ?>">
    </div>

    <div class="mb-3">
      <label>Address</label>
      <textarea name="shop_address" class="form-control"><?php echo e($settings['shop_address']); ?></textarea>
    </div>

    <button class="btn btn-primary">Save Changes</button>
  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
<?php if (!empty($_SESSION['settings_success'])): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Settings Updated',
    text: 'Pengaturan berhasil disimpan.',
});
</script>
<?php unset($_SESSION['settings_success']); endif; ?>

<?php if (!empty($_SESSION['settings_error'])): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Update Failed',
    text: '<?php echo $_SESSION['settings_error']; ?>',
});
</script>
<?php unset($_SESSION['settings_error']); endif; ?>
