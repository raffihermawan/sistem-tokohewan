<?php
$title = 'Add Pet';
require_once __DIR__ . '/../init.php';
require_login();

// PROCESS FORM AT TOP
$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = clean_input($_POST['name'] ?? '');
    $type  = clean_input($_POST['type'] ?? '');
    $breed = clean_input($_POST['breed'] ?? '');
    $age   = (int)($_POST['age'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);

    // --- IMAGE UPLOAD ---
    $imageName = null;

    if (!empty($_FILES['image']['name'])) {

        $uploadDir = __DIR__ . '/../uploads/pets/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (!in_array($ext, $allowed)) {
            $err = "Invalid file type. Only JPG/PNG/GIF allowed.";
        } else {
            $imageName = 'pet_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        }
    }

    // --- INSERT DATA ---
    if (!$err && $name) {

        $stmt = $pdo->prepare("
            INSERT INTO pets (name, type, breed, age, price, stock, image)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $type,
            $breed,
            $age,
            $price,
            $stock,
            $imageName
        ]);

        header('Location: index.php');
        exit;
    }
}

// LOAD TEMPLATE
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
    <h3>Add Pet</h3>

    <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo $err; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <input name="type" class="form-control">
        </div>

        <div class="mb-3">
            <label>Breed</label>
            <input name="breed" class="form-control">
        </div>

        <div class="mb-3">
            <label>Age</label>
            <input name="age" type="number" class="form-control">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input name="price" type="number" class="form-control">
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input name="stock" type="number" class="form-control">
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary">Save</button>

    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
