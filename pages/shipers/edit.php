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

$shipment = query("SELECT * FROM shipments WHERE id = $id")[0] ?? null;
if (!$shipment) {
    header('Location: index.php');
    exit;
}

$items = query("SELECT * FROM items");
$senders = query("SELECT * FROM senders");
$receivers = query("SELECT * FROM receivers");

if (isset($_POST['submit'])) {
    $data = [
        'tracking_number' => $_POST['tracking_number'],
        'item_id' => $_POST['item_id'],
        'sender_id' => $_POST['sender_id'],
        'receiver_id' => $_POST['receiver_id'],
        'status' => $_POST['status'],
    ];
    if (update('shipments', $data, $id) >= 0) {
        header('Location: index.php?message=update');
        exit;
    }
}

$title = "Edit Pengiriman";
$items = [
    ['label' => 'Dashboard', 'url' => '../dashboard.php'],
    ['label' => 'Pengiriman', 'url' => '../shipers/index.php'],
    ['label' => 'Edit', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex align-items-center justify-content-center row">
    <div class="col-sm-10">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">
                            Nomor Resi <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9">
                            <input type="text" name="tracking_number" class="form-control" required
                                value="<?= htmlspecialchars($shipment->tracking_number) ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">
                            Nama Barang <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9">
                            <select name="item_id" class="form-control" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($data as $item): ?>
                                    <option value="<?= $item->id ?>" <?= $shipment->item_id == $item->id ? 'selected' : '' ?>>
                                        <?= $item->name ?> (Kategori: <?= $item->category ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">
                            Pengirim <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9">
                            <select name="sender_id" class="form-control" required>
                                <option value="">-- Pilih Pengirim --</option>
                                <?php foreach ($senders as $item): ?>
                                    <option value="<?= $item->id ?>" <?= $shipment->sender_id == $item->id ? 'selected' : '' ?>>
                                        <?= $item->name ?> (<?= $item->city ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">
                            Pengirim <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-9">
                            <select name="receiver_id" class="form-control" required>
                                <option value="">-- Pilih Pengirim --</option>
                                <?php foreach ($receivers as $item): ?>
                                    <option value="<?= $item->id ?>" <?= $shipment->receiver_id == $item->id ? 'selected' : '' ?>>
                                        <?= $item->name ?> (<?= $item->city ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-lg-3 col-form-label">Status</label>
                        <div class="col-lg-9">
                            <select name="status" class="form-control">
                                <?php
                                $statuses = ["Proses", "Dikirim", "Diterima", "Batal"];
                                foreach ($statuses as $status):
                                    ?>
                                    <option value="<?= $status ?>" <?= $shipment->status == $status ? 'selected' : '' ?>>
                                        <?= $status ?></option>
                                <?php endforeach; ?>
                            </select>
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