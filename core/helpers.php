<?php
// core/helpers.php - common helpers
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function flash_set($key, $msg) {
    if (!isset($_SESSION)) session_start();
    $_SESSION['flash'][$key] = $msg;
}
function flash_get($key) {
    if (!isset($_SESSION)) session_start();
    if (!isset($_SESSION['flash'][$key])) return null;
    $msg = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function base_url($path = '') {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
