<?php
require_once __DIR__ . '/../init.php';
// Simple JSON search for pets and customers
$q = $_GET['q'] ?? '';
$q = "%" . $q . "%";

$results = [];
$stmt = $pdo->prepare('SELECT id,name,price,stock FROM pets WHERE name LIKE ? LIMIT 10');
$stmt->execute([$q]);
$results['pets'] = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT id,name,phone FROM customers WHERE name LIKE ? LIMIT 10');
$stmt->execute([$q]);
$results['customers'] = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($results);
