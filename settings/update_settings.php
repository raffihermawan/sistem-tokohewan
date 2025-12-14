<?php
require_once __DIR__ . '/../init.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: settings.php");
    exit;
}

$shop_name    = clean_input($_POST['shop_name'] ?? '');
$shop_email   = clean_input($_POST['shop_email'] ?? '');
$shop_phone   = clean_input($_POST['shop_phone'] ?? '');
$shop_address = clean_input($_POST['shop_address'] ?? '');

if ($shop_name) {
    $stmt = $pdo->prepare("
        UPDATE settings 
        SET shop_name=?, shop_email=?, shop_phone=?, shop_address=?, updated_at=NOW()
        WHERE id=1
    ");
    $stmt->execute([
        $shop_name,
        $shop_email,
        $shop_phone,
        $shop_address
    ]);

    $_SESSION['settings_success'] = true;
} else {
    $_SESSION['settings_error'] = "Shop name is required.";
}

header("Location: settings.php");
exit;
