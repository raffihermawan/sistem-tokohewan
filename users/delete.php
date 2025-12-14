<?php
require_once __DIR__ . '/../init.php';
require_role('admin');
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM users WHERE id=?');
    $stmt->execute([$id]);
}
header('Location: index.php');
exit;
