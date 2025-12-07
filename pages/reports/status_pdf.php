<?php
require('./../../config.php');
require('./../../app/function/function.php');
require('./../../vendor/autoload.php');

use Dompdf\Dompdf;
use Dompdf\Options;

$status = $_GET['status'] ?? "Semua";
$where = "";
if ($status !== "Semua") {
  $where = " WHERE shipments.status = '$status' ";
}

$shipments = query("
  SELECT
    shipments.*,
    items.name AS item_name,
    receivers.name AS receiver_name,
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
  $where
  ORDER BY shipments.created_at DESC
");

$html = '
<h2 style="text-align:center">Laporan Pengiriman Berdasarkan Status</h2>
<p>Status: ' . $status . '</p>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<tr>
<th>No</th>
<th>Resi</th>
<th>Barang</th>
<th>Pengirim</th>
<th>Penerima</th>
<th>Kurir</th>
<th>Status</th>
<th>Tanggal</th>
</tr>';

$no = 1;
foreach ($shipments as $s) {
  $html .= '<tr>
    <td>' . $no++ . '</td>
    <td>' . $s->tracking_number . '</td>
    <td>' . $s->item_name . '</td>
    <td>' . $s->sender_name . '</td>
    <td>' . $s->receiver_name . ' (' . $s->receiver_city . ')</td>
    <td>' . ($s->courier_name ?? 'Belum Assign') . '</td>
    <td>' . $s->status . '</td>
    <td>' . date('d M Y', strtotime($s->created_at)) . '</td>
  </tr>';
}

$html .= '</table>';

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Laporan_Pengiriman_Status_$status.pdf", ["Attachment" => false]);
