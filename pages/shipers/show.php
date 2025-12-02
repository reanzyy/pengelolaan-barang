<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAuth();

$id = $_GET['id'] ?? null;
if (!$id) {
  header('Location: index.php');
  exit;
}

$shipment = query("
    SELECT 
        shipments.*, 
        items.name AS item_name, items.category AS item_category, items.weight AS item_weight, items.type AS item_type,
        senders.name AS sender_name, senders.phone AS sender_phone, senders.city AS sender_city, senders.city AS sender_address,
        receivers.name AS receiver_name, receivers.phone AS receiver_phone, receivers.city AS receiver_city, receivers.city AS receiver_address
    FROM shipments
    JOIN items ON shipments.item_id = items.id
    JOIN senders ON shipments.sender_id = senders.id
    JOIN receivers ON shipments.receiver_id = receivers.id
    WHERE shipments.id = $id
")[0] ?? null;
?>

<?php $title = "Detail Pengiriman";
$items = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => isAdmin() ? 'Pengiriman' : 'Pengiriman Saya', 'url' => isAdmin() ? '../shipers/index.php' : '../assigned/index.php'],
  ['label' => 'Detail', 'url' => '']
];

include('./../../views/layouts/main-header.php'); ?>

<div class="d-flex align-items-end row">
  <div class="col-sm-12">
    <div class="card shadow-sm mb-4 border-0">
      <div class="card-body px-4 py-4">
        <h5 class="fw-bold mb-3">Nomor Resi</h5>
        <div class="d-flex align-items-center justify-content-between">
          <span class="fs-4 fw-bold text-primary"><?= $shipment->tracking_number ?></span>
          <span class="badge 
                    <?= $shipment->status == 'Proses' ? 'bg-secondary' : '' ?>
                    <?= $shipment->status == 'Dikirim' ? 'bg-warning text-dark' : '' ?>
                    <?= $shipment->status == 'Diterima' ? 'bg-success' : '' ?>
                    <?= $shipment->status == 'Batal' ? 'bg-danger' : '' ?>">
            <?= $shipment->status ?>
          </span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Data Pengirim</h5>
            <p class="mb-0"><?= $shipment->sender_name ?></p>
            <small class="text-muted"><?= $shipment->sender_phone ?></small>
            <p class="mt-2 mb-0"><?= $shipment->sender_address ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Data Penerima</h5>
            <p class="mb-0"><?= $shipment->receiver_name ?></p>
            <small class="text-muted"><?= $shipment->receiver_phone ?></small>
            <p class="mt-2 mb-0"><?= $shipment->receiver_address ?></p>
          </div>
        </div>
      </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Informasi Barang</h5>

        <table class="table table-bordered mb-0">
          <tr>
            <th>Nama Barang</th>
            <td><?= $shipment->item_name ?></td>
          </tr>
          <tr>
            <th>Berat</th>
            <td><?= $shipment->item_weight ?> Kg</td>
          </tr>
          <tr>
            <th>Jenis</th>
            <td><?= $shipment->item_type ?></td>
          </tr>
          <tr>
            <th>Biaya Kirim</th>
            <td>Rp <?= number_format($shipment->shipping_cost, 0, ',', '.') ?></td>
          </tr>
        </table>
      </div>
    </div>

    <?php if ($shipment->proof_image): ?>
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Bukti Serah Terima</h5>
          <img src="../../assets/img/proof/<?= $shipment->proof_image ?>"
            alt="Bukti Serah Terima" class="img-fluid rounded-3 shadow-sm"
            style="max-height: 350px; cursor:pointer;" />
        </div>
      </div>
    <?php endif; ?>

    <div class="text-center mt-4">
      <a href="<?= isAdmin() ? '../shipers/index.php' : '../assigned/index.php' ?>" class="btn btn-secondary px-4">Kembali</a>
    </div>

  </div>
</div>

<?php include('./../../views/layouts/main-footer.php'); ?>