<?php
// core/role.php - role based middleware
function require_role($roles = []) {
    if (!is_array($roles)) $roles = [$roles];
    if (!is_logged_in()) {
        header('Location: ' . BASE_URL . '/auth/login.php');
        exit;
    }
    $user_role = $_SESSION['user_role'] ?? null;
    if (!in_array($user_role, $roles)) {
        http_response_code(403);
        echo "<h3>Forbidden: you don't have permission to access this page.</h3>";
        exit;
    }
}
