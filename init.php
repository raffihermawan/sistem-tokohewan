<?php
// init.php - bootstrap file
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/core/security.php';
require_once __DIR__ . '/core/helpers.php';
require_once __DIR__ . '/core/session.php';

// Start session handled in session.php
// Load role helpers after session is available
require_once __DIR__ . '/core/role.php';
