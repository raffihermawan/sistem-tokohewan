<?php
require_once __DIR__ . '/../init.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) { 
    header("Location: index.php");
    exit; 
}

// Ambil data pet
$stmt = $pdo->prepare("SELECT * FROM pets WHERE id = ?");
$stmt->execute([$id]);
$pet = $stmt->fetch();

if (!$pet) {
    header("Location: index.php");
    exit;
}

$err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = clean_input($_POST['name']);
    $type  = clean_input($_POST['type']);
    $breed = clean_input($_POST['breed']);
    $age   = (int)$_POST['age'];
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];

    // Simpan nama gambar lama kalau tidak diupdate
    $imageName = $pet['image'];

    // Jika user upload gambar baru
    if (!empty($_FILES['image']['name'])) {

        $uploadDir = __DIR__ . '/../uploads/pets/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        // Hapus gambar lama jika ada
        if ($pet['image'] && file_exists($uploadDir . $pet['image'])) {
            unlink($uploadDir . $pet['image']);
        }

        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif'];

        if (!in_array($ext, $allowed)) {
            $err = "Invalid image format. Allowed: JPG, PNG, GIF.";
        } else {
            // Generate nama baru
            $imageName = 'pet_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
        }
    }

    if (!$err) {
        $stmt = $pdo->prepare("
            UPDATE pets SET 
                name = ?, 
                type = ?, 
                breed = ?, 
                age = ?, 
                price = ?, 
                stock = ?, 
                image = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $name,
            $type,
            $breed,
            $age,
            $price,
            $stock,
            $imageName,
            $id
        ]);

        header("Location: index.php");
        exit;
    }
}

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/topbar.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="container-fluid">
    <h3>Edit Pet</h3>

    <?php if ($err): ?>
        <div class="alert alert-danger"><?php echo $err; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Name</label>
            <input name="name" class="form-control" value="<?php echo e($pet['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Type</label>
            <input name="type" class="form-control" value="<?php echo e($pet['type']); ?>">
        </div>

        <div class="mb-3">
            <label>Breed</label>
            <input name="breed" class="form-control" value="<?php echo e($pet['breed']); ?>">
        </div>

        <div class="mb-3">
            <label>Age</label>
            <input name="age" type="number" class="form-control" value="<?php echo $pet['age']; ?>">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input name="price" type="number" class="form-control" value="<?php echo $pet['price']; ?>">
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input name="stock" type="number" class="form-control" value="<?php echo $pet['stock']; ?>">
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <?php if ($pet['image']): ?>
                <img src="<?php echo base_url('uploads/pets/' . $pet['image']); ?>" 
                     style="width:100px;height:100px;object-fit:cover;border-radius:6px;">
            <?php else: ?>
                <span class="text-muted">No image uploaded</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>New Image (optional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>

</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
