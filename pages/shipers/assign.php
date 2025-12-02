<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAuth(); // hanya user login

// Cek jika form disubmit
if (isset($_POST['submit'])) {
  $shipment_id = $_POST['shipment_id'];
  $courier_id  = $_POST['courier_id'];

  // Validasi agar shipment tidak bisa assigned 2 kali
  $existing = query("SELECT * FROM shipment_assignments WHERE shipment_id = $shipment_id LIMIT 1")[0];
  if ($existing) {
    header("Location: index.php?message=already_assigned");
    exit;
  }

  // Simpan data assignment
  $data = [
    'shipment_id' => $shipment_id,
    'courier_id' => $courier_id,
    'assigned_at' => date('Y-m-d H:i:s')
  ];

  if (store('shipment_assignments', $data) > 0) {
    header("Location: index.php?message=assigned_success");
    exit;
  } else {
    $error = "Gagal menetapkan kurir!";
  }
}

// Ambil parameter
$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: index.php");
  exit;
}

$shipment = query("SELECT * FROM shipments JOIN receivers ON shipments.receiver_id = receivers.id WHERE shipments.id = $id LIMIT 1")[0];
$couriers = query("SELECT * FROM users WHERE role = 'courier'");

$title = "Assign Kurir";
$breadcrumbs = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => 'Pengiriman', 'url' => 'index.php'],
  ['label' => 'Assign Kurir', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex justify-content-center row">
  <div class="col-sm-8">
    <div class="card shadow-sm">
      <div class="card-header fw-bold">Assign Kurir untuk Pengiriman</div>
      <div class="card-body">

        <?php if (isset($error)) : ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <table class="table table-bordered mb-4">
          <tr>
            <th>Nomor Resi</th>
            <td><?= $shipment->tracking_number ?></td>
          </tr>
          <tr>
            <th>Nama Penerima</th>
            <td><?= $shipment->name ?></td>
          </tr>
          <tr>
            <th>Status Saat Ini</th>
            <td><?= $shipment->status ?></td>
          </tr>
        </table>

        <form action="" method="POST">
          <input type="hidden" name="shipment_id" value="<?= $_GET['id'] ?>">
          <div class="mb-3">
            <label class="form-label">Pilih Kurir <span class="text-danger">*</span></label>
            <select name="courier_id" class="form-control" required>
              <option value="">-- Pilih Kurir --</option>
              <?php foreach ($couriers as $courier) : ?>
                <option value="<?= $courier->id ?>"><?= $courier->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="card-footer text-end border-top pt-3">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-primary" name="submit">Assign Sekarang</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include('./../../views/layouts/main-footer.php'); ?>