<?php
require __DIR__ . '/../../config.php';
require __DIR__ . '/../../app/middleware.php';
require __DIR__ . '/../../app/auth.php';

checkGuest();
?>

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login</title>

    <link rel="icon" type="image/x-icon" href="/assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="/assets/css/page-auth.css" />

    <?php include __DIR__ . '/../../views/layouts/partials/head.php'; ?>
</head>

<body>

    <?php include __DIR__ . '/../../views/layouts/components/breadcrumd.php'; ?>

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-center mb-2">
                            <img src="/assets/img/favicon/favicon.ico" width="100">
                        </div>

                        <h4 class="text-center">Selamat datang di<br>
                            <b>Aplikasi Pengelolaan Barang</b>
                        </h4>

                        <p class="mb-2">Silahkan login untuk memasuki aplikasi</p>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post">

                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button class="btn btn-primary w-100" name="submit" type="submit">Sign in</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/assets/vendor/js/bootstrap.js"></script>
    <script src="/assets/vendor/js/menu.js"></script>
    <script src="/assets/js/main.js"></script>

</body>

</html>