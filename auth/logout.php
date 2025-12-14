<?php
require_once __DIR__ . '/../init.php';

session_start();

// simpan pesan flash ke session
$_SESSION['logout_success'] = true;

// hancurkan session user
session_unset();
session_destroy();

// redirect ke login (tanpa output apapun)
header('Location: ' . BASE_URL . '/auth/login.php');
exit;
