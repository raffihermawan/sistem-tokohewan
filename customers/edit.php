<?php
// ==============================================
// 1. INIT & AUTH DULU — WAJIB DI PALING ATAS
// ==============================================
require_once __DIR__ . '/../init.php';
require_login();

$title = 'Edit Customer';

// ==============================================
// 2. AMBIL DATA CUSTOMER — SEBELUM ADA HTML
// ==============================================
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM customers WHERE id = ?');
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    header('Location: index.php');
    exit;
}

// ==============================================
// 3. PROSES FORM — MASIH SEBELUM TEMPLATE DI-LOAD
// ==============================================
$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = clean_input($_POST['name'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $address = clean_input($_POST['address'] ?? '');

    if ($name) {
        $stmt = $pdo->prepare(
            'UPDATE customers SET name=?,phone=?,email=?,address=? WHERE id=?'
        );
        $stmt->execute([$name, $phone, $email, $address, $id]);

        // Redirect aman karena belum ada HTML
        header('Location: index.php');
        exit;
    } else {
        $err = 'Name is required';
    }
}

// ==============================================
// 4. BARU LOAD TEMPLATE SETELAH SEMUA LOGIC BERES
// ==============================================
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
  <h3>Edit Customer</h3>

  <?php if ($err): ?>
    <div class="alert alert-danger"><?php echo e($err); ?></div>
  <?php endif; ?>

  <form method="post">

    <div class="mb-3">
      <label>Name</label>
      <input name="name" class="form-control" 
             value="<?php echo e($customer['name']); ?>" required>
    </div>

    <div class="mb-3">
      <label>Phone</label>
      <input name="phone" class="form-control" 
             value="<?php echo e($customer['phone']); ?>">
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input name="email" type="email" class="form-control" 
             value="<?php echo e($customer['email']); ?>">
    </div>

    <div class="mb-3">
      <label>Address</label>
      <textarea name="address" class="form-control"><?php echo e($customer['address']); ?></textarea>
    </div>

    <button class="btn btn-primary">Update</button>

  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
