<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAuth()
{
    if (!isset($_SESSION['user'])) {
        $request = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        $_SESSION['next'] = $request;
        if (defined('BASE_URL')) {
            header('Location: ' . '/pages/auth/login.php');
        } else {
            header('Location: /pages/auth/login.php');
        }
        exit;
    }
}

function checkAdmin()
{
    checkAuth();

    if ($_SESSION['user']['role'] !== 'admin') {
        if (defined('BASE_URL')) {
            header('Location: ' . '/pages/dashboard.php');
        } else {
            header('Location: /pages/dashboard.php');
        }
        exit;
    }
}

function isAdmin()
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function checkGuest()
{
    if (isset($_SESSION['user'])) {
        if (defined('BASE_URL')) {
            header('Location: ' . '/pages/dashboard.php');
        } else {
            header('Location: /pages/dashboard.php');
        }
        exit;
    }
}
