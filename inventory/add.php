<?php
require_once __DIR__ . '/../init.php';
require_login();

$pet_id = $_POST['pet_id'] ?? null;
$qty = (int)($_POST['qty'] ?? 0);
$note = clean_input($_POST['note'] ?? '');

if ($pet_id && $qty > 0) {
    $stmt = $pdo->prepare('UPDATE pets SET stock = stock + ? WHERE id=?');
    $stmt->execute([$qty, $pet_id]);
    $stmt = $pdo->prepare('INSERT INTO inventory_history (pet_id,change_type,qty,note) VALUES (?,?,?,?)');
    $stmt->execute([$pet_id, 'add', $qty, $note]);
}
header('Location: index.php');
exit;
