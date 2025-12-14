<?php
// core/security.php - sanitization helpers

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function clean_input($data) {
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Prepared statements should be used for DB queries to prevent SQL injection.
