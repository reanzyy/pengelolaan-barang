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

$shipment = query("SELECT * FROM shipments WHERE id = $id")[0] ?? null;
if (!$shipment) {
  header('Location: index.php');
  exit;
}

if (isset($_POST['submit'])) {
  $status = $_POST['status'];
  $file = $shipment->proof_image;

  if ($status === "Diterima") {
    if (!empty($_FILES['proof_image']['name'])) {
      $ext = pathinfo($_FILES['proof_image']['name'], PATHINFO_EXTENSION);
      $newName = 'proof_' . time() . '.' . $ext;
      $uploadPath = './../../assets/img/proof/' . $newName;
      move_uploaded_file($_FILES['proof_image']['tmp_name'], $uploadPath);
      $file = $newName;
    } else {
      $error = "Bukti foto wajib diupload jika barang sudah diterima!";
    }
  }

  if (!isset($error)) {
    $data = [
      'status' => $status,
      'proof_image' => $file
    ];

    if (update('shipments', $data, $id) >= 0) {
      header('Location: index.php?message=update_status');
      exit;
    }
  }
}

$title = "Update Status Pengiriman";
$items = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => 'Pengiriman Saya', 'url' => '../assigned/index.php'],
  ['label' => 'Update Status', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex align-items-center justify-content-center row">
  <div class="col-sm-10">
    <div class="card">
      <div class="card-body">

        <?php if (isset($error)) : ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
          <div class="form-group row mb-3">
            <label class="col-lg-3 col-form-label">
              Nomor Resi
            </label>
            <div class="col-lg-9">
              <input type="text" class="form-control" value="<?= $shipment->tracking_number ?>" readonly>
            </div>
          </div>

          <div class="form-group row mb-3">
            <label class="col-lg-3 col-form-label">Status <span class="text-danger">*</span></label>
            <div class="col-lg-9">
              <select name="status" class="form-control">
                <?php
                $statuses = ["Proses", "Dikirim", "Diterima", "Batal"];
                foreach ($statuses as $status): ?>
                  <option value="<?= $status ?>" <?= $shipment->status == $status ? 'selected' : '' ?>>
                    <?= $status ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group row mb-3" id="proofContainer" style="display: none;">
            <label class="col-lg-3 col-form-label">
              Bukti Serah Terima (Foto) <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
              <?php if ($shipment->proof_image): ?>
                <div class="mb-2">
                  <img src="../../assets/img/proof/<?= $shipment->proof_image ?>" alt="Bukti"
                    style="max-height: 160px; border:2px solid #ddd; border-radius:5px;">
                </div>
              <?php endif; ?>
              <input type="file" name="proof_image" class="form-control" accept="image/*">
              <small class="text-muted">* Upload bukti hanya saat barang sudah diterima.</small>
            </div>
          </div>

          <div class="text-end">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-primary" name="submit">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const statusSelect = document.querySelector("select[name='status']");
    const proofContainer = document.getElementById("proofContainer");

    function checkStatus() {
      if (statusSelect.value === "Diterima") {
        proofContainer.style.display = "flex";
      } else {
        proofContainer.style.display = "none";
      }
    }

    checkStatus(); // cek saat halaman dibuka
    statusSelect.addEventListener("change", checkStatus);
  });
</script>
<?php include('./../../views/layouts/main-footer.php'); ?>