<?php
// logic yang berada di folder app
require('./../../app/sender.php');

if (isset($_POST['submit'])) {
  if (store($_POST) > 0) {
    header('Location: index.php?message=store');
    exit;
  }
}

// breadcrumnd
$title = "Tambah Pengirim";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Pengirim', 'url' => '../senders/index.php'],
    ['label' => 'Tambah', 'url' => '']
];

include('./../../views/layouts/main-header.php');

?>

<div class="card">
    <div class="card-body">
        <?php if (!empty($error)) : ?>
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

<?php include('./../../views/layouts/main-footer.php') ?>
