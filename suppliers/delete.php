<?php
require_once __DIR__ . '/../init.php';
require_login();
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM suppliers WHERE id=?');
    $stmt->execute([$id]);
}
header('Location: index.php');
exit;
