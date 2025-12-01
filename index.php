<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    if (defined('BASE_URL')) {
        header('Location: ' . '/pages/auth/login.php');
    } else {
        header('Location: /pages/auth/login.php');
    }
    exit;
}

if (defined('BASE_URL')) {
    header('Location: ' . '/pages/dashboard.php');
} else {
    header('Location: /pages/dashboard.php');
}
exit;