<?php
require('./../../app/function/function.php');

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$item = query("SELECT * FROM items WHERE id = $id")[0] ?? null;
if (!$item) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['submit'])) { 
    $data = [
        'name'     => $_POST['name'],
        'category' => $_POST['category'],
        'weight'   => $_POST['weight']
    ];
    if (update('items', $data, $id) >= 0) { 
        header('Location: index.php?message=update');
        exit;
    } else {
        $error = "Gagal mengupdate data!";
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
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Nama Barang <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="name" class="form-control" required
                                   value="<?= htmlspecialchars($item->name) ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Kategori <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="text" name="category" class="form-control" required
                                   value="<?= htmlspecialchars($item->category) ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Berat (gram) <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="weight" class="form-control" required
                                   value="<?= htmlspecialchars($item->weight) ?>">
                        </div>
                    </div>
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
