<?php
require_once __DIR__ . '/../init.php';

// Create default admin if not exists
$email = 'admin@petshop.local';
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo "Admin already exists.";
    exit;
}

$hash = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)');
$stmt->execute(['Administrator',$email,$hash,'admin']);

echo "Default admin created. Email: $email, Password: admin123";

?>
