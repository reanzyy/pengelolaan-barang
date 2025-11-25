<?php
// logic yang berada di folder app
require('./../../app/item.php'); // pastikan file app/item.php ada function update

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Ambil data barang berdasarkan ID
$item = query("SELECT * FROM items WHERE id = $id")[0] ?? null;
if (!$item) {
    header('Location: index.php');
    exit;
}

// Logic untuk update data
if (isset($_POST['submit'])) {
    if (update($_POST, $id) > 0) { // sesuaikan function update di app/item.php
        header('Location: index.php?message=update');
        exit;
    }
}

$title = "Edit Barang";
$items_breadcrumb = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Barang', 'url' => '../items/index.php'],
    ['label' => 'Edit', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex align-items-center justify-content-center row">
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">

                    <!-- NAMA BARANG -->
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Nama Barang <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="name" class="form-control" required
                                   value="<?= htmlspecialchars($item->name) ?>">
                        </div>
                    </div>

                    <!-- KATEGORI -->
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Kategori <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="category" class="form-control" required
                                   value="<?= htmlspecialchars($item->category) ?>">
                        </div>
                    </div>

                    <!-- BERAT -->
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Berat (gram) <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="weight" class="form-control" required
                                   value="<?= htmlspecialchars($item->weight) ?>">
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="card-footer text-end border-top">
                        <span class="text-muted float-start">
                            <strong class="text-danger">*</strong> Harus diisi
                        </span>
                        <div class="float-end">
                            <a href="index.php" class="btn btn-secondary">Kembali</a>
                            <button class="btn btn-primary" name="submit">Simpan</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include('./../../views/layouts/main-footer.php') ?>
