<?php
require_once __DIR__ . '/../init.php';
require_login();

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT image FROM pets WHERE id=?");
$stmt->execute([$id]);
$pet = $stmt->fetch();

if ($pet) {
    $uploadDir = __DIR__ . '/../uploads/pets/';

    // Hapus file
    if ($pet['image'] && file_exists($uploadDir . $pet['image'])) {
        unlink($uploadDir . $pet['image']);
    }

    // Hapus DB row
    $stmt = $pdo->prepare("DELETE FROM pets WHERE id=?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
