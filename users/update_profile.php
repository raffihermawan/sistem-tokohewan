<?php
require_once __DIR__ . '/../init.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profile.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$name     = clean_input($_POST['name'] ?? '');
$email    = clean_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$name || !$email) {
    $_SESSION['profile_error'] = "Name and email are required.";
    header("Location: profile.php");
    exit;
}

// Jika password diisi → update password + updated_at
if (!empty($password)) {

    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("
        UPDATE users 
        SET name=?, email=?, password=?, updated_at=NOW()
        WHERE id=?
    ");
    $stmt->execute([$name, $email, $hashed, $user_id]);

} else {

    $stmt = $pdo->prepare("
        UPDATE users 
        SET name=?, email=?, updated_at=NOW()
        WHERE id=?
    ");
    $stmt->execute([$name, $email, $user_id]);
}

// Update session
$_SESSION['user_name']  = $name;
$_SESSION['user_email'] = $email;

$_SESSION['profile_success'] = true;

header("Location: profile.php");
exit;
