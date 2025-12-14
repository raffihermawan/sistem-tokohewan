<?php
require_once 'init.php';
if (!is_logged_in()) {
    header("Location: login.php");
    exit;
}

$user_id = $user['id'];
$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
$data = $query->fetch_assoc();
?>

<?php include 'layouts/header.php'; ?>

<div class="container mt-4" style="max-width: 600px;">
    <h3>Edit Profile</h3>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="mt-3">

        <div class="mb-3">
            <label>Fullname</label>
            <input type="text" name="fullname" class="form-control" value="<?= $data['fullname'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Avatar (optional)</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button class="btn btn-success">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

<?php include 'layouts/footer.php'; ?>
