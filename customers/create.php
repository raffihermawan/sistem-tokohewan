<?php
// ============================
// WAJIB DI PALING ATAS
// ============================
require_once __DIR__ . '/../init.php';
require_login();

$title = 'Add Customer';

// PROSES FORM DULU – sebelum HTML atau include file apapun
$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = clean_input($_POST['name'] ?? '');
    $phone   = clean_input($_POST['phone'] ?? '');
    $email   = clean_input($_POST['email'] ?? '');
    $address = clean_input($_POST['address'] ?? '');

    if ($name) {
        $stmt = $pdo->prepare(
            'INSERT INTO customers (name,phone,email,address) VALUES (?,?,?,?)'
        );
        $stmt->execute([$name, $phone, $email, $address]);

        // SAFE – karena belum ada HTML dari template
        header("Location: index.php");
        exit;
    } else {
        $err = "Name is required";
    }
}

// ============================
// Setelah logic, baru load HTML
// ============================

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
  <h3>Add Customer</h3>

  <?php if ($err): ?>
    <div class="alert alert-danger"><?php echo e($err); ?></div>
  <?php endif; ?>

  <form method="post">
      <div class="mb-3">
          <label>Name</label>
          <input name="name" class="form-control" required>
      </div>

      <div class="mb-3">
          <label>Phone</label>
          <input name="phone" class="form-control">
      </div>

      <div class="mb-3">
          <label>Email</label>
          <input name="email" class="form-control" type="email">
      </div>

      <div class="mb-3">
          <label>Address</label>
          <textarea name="address" class="form-control"></textarea>
      </div>

      <button class="btn btn-primary">Save</button>
  </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
