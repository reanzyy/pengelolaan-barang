<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAuth();

$courierId = authUser()->id;
$no = 1;
$assignments = query("
    SELECT 
      s.id, s.tracking_number,
      items.name AS item_name,
      s.status, s.proof_image,
      receivers.name AS receiver_name,
      receivers.phone AS receiver_phone
    FROM shipment_assignments a
      JOIN shipments s ON a.shipment_id = s.id
      JOIN items ON s.item_id = items.id
      JOIN receivers ON s.receiver_id = receivers.id
    WHERE a.courier_id = $courierId
");

$title = "Tugas Pengiriman Saya";
$items = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => 'Pengiriman Saya', 'url' => '../assigned/index.php'],
  ['label' => 'Daftar', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="card">
  <div class="d-flex align-items-end row">
    <div class="col-sm-12">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table datatable" style="width: 100%;">
            <thead>
              <tr>
                <th>No</th>
                <th>Resi</th>
                <th>Nama Barang</th>
                <th>Penerima</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($assignments as $row): ?>
                <tr>
                  <td class="text-nowrap"><?= $no++ ?></td>
                  <td class="text-nowrap fw-bold"><?= $row->tracking_number ?></td>
                  <td class="text-nowrap"><?= $row->item_name ?></td>
                  <td class="text-nowrap"><?= $row->receiver_name ?> <br>
                    <small class="text-muted"><?= $row->receiver_phone ?></small>
                  </td>
                  <td class="text-nowrap">
                    <?php
                    $badgeClass = [
                      "Proses"   => "bg-warning text-dark",
                      "Dikirim"  => "bg-primary",
                      "Diterima" => "bg-success",
                      "Batal"    => "bg-danger",
                    ];
                    ?>
                    <span class="badge <?= $badgeClass[$row->status] ?? "bg-secondary" ?>">
                      <?= $row->status ?>
                    </span>
                  </td>
                  <td class="text-nowrap">
                    <?php if ($row->proof_image): ?>
                      <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal"
                        data-bs-target="#modalProof<?= $row->id ?>">
                        Lihat
                      </button>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-nowrap">
                    <a href="update-status.php?id=<?= $row->id ?>" class="btn btn-success btn-sm">
                      Update Status
                    </a>
                    <a href="../shipers/show.php?id=<?= $row->id ?>" class="btn btn-info btn-sm text-white">
                      Detail
                    </a>
                  </td>
                </tr>

                <?php if ($row->proof_image): ?>
                  <div class="modal fade" id="modalProof<?= $row->id ?>" tabindex="-1">
                    <div class="modal-dialog modal-fullscreen">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Bukti Serah Terima — <?= $row->tracking_number ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                          <img src="../../assets/img/proof/<?= $row->proof_image ?>"
                            class="img-fluid rounded" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <?php include('./../../views/layouts/main-footer.php'); ?>