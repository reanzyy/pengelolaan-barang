<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAuth();

$title = "Daftar Pengiriman";
$items = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => 'Pengiriman', 'url' => '../shipers/index.php'],
  ['label' => 'Daftar', 'url' => '']
];

$action_buttons = [
  ['icon' => '<i class="bx bx-plus"></i>', 'text' => 'Tambah Data', 'url' => 'create.php', 'class' => 'btn-primary'],
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
                <th width="5%">No</th>
                <th>Resi</th>
                <th>Nama Barang</th>
                <th>Kategori Barang</th>
                <th>Pengirim</th>
                <th>Penerima</th>
                <th>Asal→Tujuan</th>
                <th>Status</th>
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $no = 1;
              $shipments = query("
                  SELECT 
                      shipments.*,
                      items.name AS item_name,
                      senders.name AS sender_name,
                      senders.phone AS sender_phone,
                      senders.city AS sender_city,
                      receivers.name AS receiver_name,
                      receivers.phone AS receiver_phone,
                      receivers.city AS receiver_city,
                      items.category AS item_category
                  FROM shipments
                  JOIN items ON shipments.item_id = items.id
                  JOIN senders ON shipments.sender_id = senders.id
                  JOIN receivers ON shipments.receiver_id = receivers.id
                  GROUP BY shipments.id
              ");
              ?>

              <?php foreach ($shipments as $shipment): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $shipment->tracking_number ?></td>
                  <td><?= $shipment->item_name ?></td>
                  <td><?= $shipment->item_category ?></td>
                  <td><?= $shipment->sender_name ?> <br>
                    <span> <?= $shipment->sender_phone ?> </span>
                  </td>
                  <td><?= $shipment->receiver_name ?> <br>
                    <span> <?= $shipment->receiver_phone ?> </span>
                  </td>
                  <td><?= $shipment->sender_city ?> → <?= $shipment->receiver_city ?></td>
                  <td><?= $shipment->status ?></td>
                  <td class="text-end">
                    <div class="d-flex gap-1">
                      <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $shipment->id ?>">
                        <i class="bx bx-edit-alt"></i>Ubah
                      </a>
                      <button type="button" data-action="delete.php?id=<?= $shipment->id ?>"
                        data-confirm-text="Anda yakin menghapus data pengiriman ini?"
                        class="btn btn-sm btn-danger btn-delete">
                        <i class="bx bx-trash"></i>Hapus
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('./../../views/layouts/main-footer.php') ?>