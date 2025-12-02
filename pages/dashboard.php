<?php
require('./../config.php');
require './../app/function/function.php';
require('./../app/middleware.php');

checkAuth();

$courier_id = !isAdmin() ? authUser()->id : null;

$total = query("SELECT COUNT(*) AS c FROM shipment_assignments RIGHT JOIN shipments ON shipment_assignments.shipment_id = shipments.id" . ($courier_id ? " WHERE courier_id = '$courier_id'" : ""))[0]->c;
$proses = query("SELECT COUNT(*) AS c FROM shipment_assignments RIGHT JOIN shipments ON shipment_assignments.shipment_id = shipments.id WHERE status = 'Proses'" . ($courier_id ? " AND courier_id = '$courier_id'" : ""))[0]->c;
$dikirim = query("SELECT COUNT(*) AS c FROM shipment_assignments RIGHT JOIN shipments ON shipment_assignments.shipment_id = shipments.id WHERE status = 'Dikirim'" . ($courier_id ? " AND courier_id = '$courier_id'" : ""))[0]->c;
$diterima = query("SELECT COUNT(*) AS c FROM shipment_assignments RIGHT JOIN shipments ON shipment_assignments.shipment_id = shipments.id WHERE status = 'Diterima'" . ($courier_id ? " AND courier_id = '$courier_id'" : ""))[0]->c;

$userName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'User';
include('./../views/layouts/main-header.php')
?>

<div class="card mb-4">
  <div class="d-flex align-items-end row">
    <div class="col-sm-8">
      <div class="card-body">
        <h5 class="card-title text-primary">Selamat Datang <?php echo htmlspecialchars($userName); ?>! 🎉</h5>
        <p class="mb-4">
          Kendalikan Efisiensi Mobilitas: Portal Admin Sistem Pengelolaan Barang
        </p>
      </div>
    </div>
    <div class="col-sm-4 text-center text-sm-left">
      <div class="card-body pb-0 px-0 px-md-4">
        <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User"
          data-app-dark-img="illustrations/man-with-laptop-dark.png"
          data-app-light-img="illustrations/man-with-laptop-light.png" />
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-start border-4 border-primary">
      <div class="card-body">
        <h6 class="text-muted mb-1">Total Assigned</h6>
        <h2 class="fw-bold"><?= $total ?></h2>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-start border-4 border-warning">
      <div class="card-body">
        <h6 class="text-muted mb-1">Dalam Proses</h6>
        <h2 class="fw-bold"><?= $proses ?></h2>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-start border-4 border-info">
      <div class="card-body">
        <h6 class="text-muted mb-1">Sedang Dikirim</h6>
        <h2 class="fw-bold"><?= $dikirim ?></h2>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-start border-4 border-success">
      <div class="card-body">
        <h6 class="text-muted mb-1">Selesai / Diterima</h6>
        <h2 class="fw-bold"><?= $diterima ?></h2>
      </div>
    </div>
  </div>

</div>

<?php include('./../views/layouts/main-footer.php') ?>