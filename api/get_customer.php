<?php
require_once __DIR__ . '/../init.php';
$id = $_GET['id'] ?? null;
if (!$id) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }
$stmt = $pdo->prepare('SELECT * FROM customers WHERE id = ?');
$stmt->execute([$id]);
$c = $stmt->fetch();
header('Content-Type: application/json');
echo json_encode($c);
