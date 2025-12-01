<?php
require('connection.php');
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../../dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT id, name, username, password, role FROM users WHERE username = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id, $name, $db_username, $db_password, $role);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $db_password)) {

                $_SESSION['user'] = [
                    'id'       => $id,
                    'name'     => $name,
                    'username' => $db_username,
                    'role'     => $role
                ];

                mysqli_stmt_close($stmt);
                header('Location: ../../pages/dashboard.php');
                exit;
            }

            $error = "Password salah!";
        } else {
            $error = "Username tidak ditemukan!";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Terjadi kesalahan server.";
    }
}