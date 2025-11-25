<?php
// function yang berada di folder app
require('./../../app/shiper.php');

// ambil data item untuk dropdown
$data = query("SELECT * FROM items");
$senders = query("SELECT * FROM senders");
$receivers = query("SELECT * FROM receivers");

// logic untuk create data
if (isset($_POST['submit'])) {
    if (store($_POST) > 0) { // ganti sesuai function create di app
        header('Location: index.php?message=store');
        exit;
    }
}

$title = "Daftar Pengiriman";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Pengiriman', 'url' => '../shipers/index.php'],
    ['label' => 'Daftar', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex align-items-center justify-content-center row">
    <div class="col-sm-10">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">

                    <div class="card-body">

                        <!-- NOMOR RESI -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-3 col-form-label">
                                Nomor Resi <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="text" name="tracking_number" class="form-control" required>
                            </div>
                        </div>

                        <!-- ITEM -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-3 col-form-label">
                                Nama Barang <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <select name="item_id" class="form-control" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?php foreach ($data as $item): ?>
                                        <option value="<?= $item->id ?>">
                                            <?= $item->name ?> (Kategori: <?= $item->category ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- PENGIRIM -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-3 col-form-label">
                                Pengirim <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <select name="sender_id" class="form-control" required>
                                    <option value="">-- Pilih Pengirim --</option>
                                    <?php foreach ($senders as $item): ?>
                                        <option value="<?= $item->id ?>">
                                            <?= $item->name ?> (<?= $item->city ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- PENERIMA -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-3 col-form-label">
                                Penerima <span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <select name="receiver_id" class="form-control" required>
                                    <option value="">-- Pilih Penerima --</option>
                                    <?php foreach ($receivers as $item): ?>
                                        <option value="<?= $item->id ?>">
                                            <?= $item->name ?> (<?= $item->city ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- STATUS -->
                        <div class="form-group row mb-3">
                            <label class="col-lg-3 col-form-label">Status</label>
                            <div class="col-lg-9">
                                <select name="status" class="form-control">
                                    <option value="Proses">Proses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Batal">Batal</option>
                                </select>
                            </div>
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