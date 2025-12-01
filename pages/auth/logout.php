<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_unset();
session_destroy();

if (defined('BASE_URL')) {
    header('Location: ' . '/pages/auth/login.php');
} else {
    header('Location: /pages/auth/login.php');
}
exit;
