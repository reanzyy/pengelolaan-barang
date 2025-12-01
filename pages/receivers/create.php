<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAdmin();

if (isset($_POST['submit'])) {
    $data = [
        'name' => $_POST['name'],
        'phone' => $_POST['phone'],
        'city' => $_POST['city'],
        'address' => $_POST['address']
    ];
    if (store('receivers', $data) > 0) {
        header('Location: index.php?message=store');
        exit;
    } else {
        $error = "Gagal membuat data!";
    }

}

$title = "Tambah Penerima";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Penerima', 'url' => '../receivers/index.php'],
    ['label' => 'Tambah', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex align-items-center justify-content-center row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Simpan
                    </button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('./../../views/layouts/main-footer.php') ?>