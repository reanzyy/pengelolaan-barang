<?php
require('./../../config.php');
require('./../../app/middleware.php');
require('./../../app/function/function.php');

checkAuth();

$title = "Laporan Pengiriman Mingguan";
$items = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => 'Laporan Mingguan', 'url' => ''],
];

$start = $_GET['start'] ?? date('Y-m-d', strtotime('-7 days'));
$end   = $_GET['end'] ?? date('Y-m-d');

$shipments = query("
    SELECT 
        shipments.*,
        items.name AS item_name,
        receivers.name AS receiver_name,
        receivers.phone AS receiver_phone,
        receivers.city AS receiver_city,
        senders.name AS sender_name,
        shipment_assignments.courier_id,
        users.name AS courier_name
    FROM shipments
    LEFT JOIN items ON shipments.item_id = items.id
    LEFT JOIN receivers ON shipments.receiver_id = receivers.id
    LEFT JOIN senders ON shipments.sender_id = senders.id
    LEFT JOIN shipment_assignments ON shipments.id = shipment_assignments.shipment_id
    LEFT JOIN users ON shipment_assignments.courier_id = users.id
    WHERE DATE(shipments.created_at) BETWEEN ? AND ?
    ORDER BY shipments.created_at DESC
", [$start, $end]);

include('./../../views/layouts/main-header.php');
?>

<div class="card">
  <div class="card-body">

    <form method="GET" class="row mb-4">
      <div class="col-md-3">
        <label class="form-label fw-bold">Tanggal Mulai</label>
        <input type="date" name="start" class="form-control" value="<?= $start ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label fw-bold">Tanggal Selesai</label>
        <input type="date" name="end" class="form-control" value="<?= $end ?>">
      </div>
      <div class="col-md-6 d-flex align-items-end gap-2">
        <button class="btn btn-primary"><i class="bx bx-search"></i> Tampilkan</button>
        <button type="button" class="btn btn-success" onclick="printDiv()"><i class="bx bx-printer"></i> Print</button>
        <a href="weekly_pdf.php?start=<?= $start ?>&end=<?= $end ?>" target="_blank" class="btn btn-danger"> <i class='bx bx-arrow-to-bottom'></i> Download PDF</a>
      </div>
    </form>

    <h6 class="fw-bold mb-3">📌 Periode: <?= date('d M Y', strtotime($start)) ?> — <?= date('d M Y', strtotime($end)) ?></h6>

    <div class="table-responsive" id="printArea">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Resi</th>
            <th>Barang</th>
            <th>Pengirim</th>
            <th>Penerima</th>
            <th>Kurir</th>
            <th>Status</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($shipments)) : ?>
            <tr>
              <td colspan="8" class="text-center text-muted">Tidak ada pengiriman untuk periode ini.</td>
            </tr>
          <?php endif; ?>

          <?php $no = 1;
          foreach ($shipments as $s) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $s->tracking_number ?></td>
              <td><?= $s->item_name ?></td>
              <td><?= $s->sender_name ?></td>
              <td><?= $s->receiver_name ?> (<?= $s->receiver_city ?>)</td>
              <td><?= $s->courier_name ?? '<span class="text-muted">Belum Assign</span>' ?></td>
              <td><?= $s->status ?></td>
              <td><?= date('d M Y', strtotime($s->created_at)) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

<script>
  function printDiv() {
    var divContents = document.getElementById("printArea").innerHTML;
    var a = window.open('', '', 'height=800, width=1000');
    a.document.write('<html><body>');
    a.document.write(divContents);
    a.document.write('</body></html>');
    a.document.close();
    a.print();
  }
</script>

<?php include('./../../views/layouts/main-footer.php'); ?>