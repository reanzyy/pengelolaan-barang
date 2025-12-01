<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAdmin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$sender = query("SELECT * FROM senders WHERE id = $id")[0] ?? null;
if (!$sender) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) {
    $data = [
        'name' => $_POST['name'],
        'phone' => $_POST['phone'],
        'city' => $_POST['city'],
        'address' => $_POST['address']
    ];
    if (update('senders', $data, $id) >= 0) {
        header('Location: index.php?message=update');
        exit;
    } else {
        $error = "Gagal mengupdate data!";
    }
}

$title = "Edit Pengirim";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Pengirim', 'url' => 'index.php'],
    ['label' => 'Edit', 'url' => '']
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
                        <input type="text" name="name" value="<?= htmlspecialchars($sender->name) ?>"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" value="<?= htmlspecialchars($sender->phone) ?>"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <input type="text" name="city" value="<?= htmlspecialchars($sender->city) ?>"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-control" rows="3"
                            required><?= htmlspecialchars($sender->address) ?></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">
                        <i class="bx bx-save"></i> Update
                    </button>

                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('./../../views/layouts/main-footer.php') ?>