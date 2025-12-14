<?php
$title = 'Edit Supplier';

// WAJIB: include init & cek login sebelum output apapun
require_once __DIR__ . '/../init.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Ambil data supplier dulu
$stmt = $pdo->prepare('SELECT * FROM suppliers WHERE id = ?');
$stmt->execute([$id]);
$s = $stmt->fetch();

if (!$s) {
    header('Location: index.php');
    exit;
}

$err = null;

// ==============================
// PROSES UPDATE SEBELUM TEMPLATE
// ==============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = clean_input($_POST['name'] ?? '');
    $phone   = clean_input($_POST['phone'] ?? '');
    $email   = clean_input($_POST['email'] ?? '');
    $address = clean_input($_POST['address'] ?? '');

    if ($name) {
        $stmt = $pdo->prepare("
            UPDATE suppliers 
            SET name=?, phone=?, email=?, address=? 
            WHERE id=?
        ");
        $stmt->execute([$name, $phone, $email, $address, $id]);

        header('Location: index.php');
        exit;
    } else {
        $err = "Name is required";
    }
}

// ===================================
// SETELAH SEMUA PROSES → LOAD TEMPLATE
// ===================================
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
    <h3>Edit Supplier</h3>

    <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo $err; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" value="<?php echo e($s['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input name="phone" class="form-control" value="<?php echo e($s['phone']); ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input name="email" class="form-control" value="<?php echo e($s['email']); ?>">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control"><?php echo e($s['address']); ?></textarea>
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
