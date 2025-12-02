<?php
require './../config.php';
require './../app/function/function.php';

$shipment = null;
$error = null;

if (isset($_GET['resi']) && $_GET['resi'] !== '') {
  $resi = trim($_GET['resi']);
  $resi_safe = addslashes($resi);

  $shipment = query("
        SELECT 
            shipments.*,
            items.name AS item_name,
            items.category AS item_category,
            items.type AS item_type,
            receivers.name AS receiver_name,
            receivers.city AS receiver_city,
            receivers.phone AS receiver_phone,
            receivers.address AS receiver_address
        FROM shipments
        JOIN items ON shipments.item_id = items.id
        JOIN receivers ON shipments.receiver_id = receivers.id
        WHERE shipments.tracking_number = '$resi_safe'
        LIMIT 1
    ");

  if ($shipment) {
    $shipment = $shipment[0];
  } else {
    $error = "Nomor resi tidak ditemukan!";
  }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Lacak Pengiriman | Cargo Tracking</title>
  <link rel="icon" type="image/x-icon" href="./../../assets/img/favicon/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: #ffffff;
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .spinner {
      width: 60px;
      height: 60px;
      border: 6px solid #e9e9e9;
      border-top-color: #dc3545;
      border-radius: 50%;
      animation: spin .9s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    body.loading {
      overflow: hidden;
    }

    body.loading #content {
      visibility: hidden;
    }

    .hero {
      background: url('../assets/img/illustrations/banner.png') center/cover no-repeat;
      padding: 130px 0;
    }

    .search-box {
      max-width: 600px;
      margin: auto;
    }

    .tracking-result {
      animation: fadeIn .5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .detail-card h5 {
      font-weight: 700;
      border-left: 5px solid #dc3545;
      padding-left: 12px;
      margin-bottom: 22px;
    }

    .detail-list {
      display: grid;
      grid-template-columns: 1fr 1fr;
      row-gap: 15px;
      column-gap: 45px;
    }

    .detail-item label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      color: #6c757d;
      margin-bottom: 3px;
      text-transform: uppercase;
    }

    .detail-item p {
      font-size: 16px;
      margin: 0;
      font-weight: 600;
      color: #212529;
    }

    .detail-section {
      border-top: 1px solid #e9ecef;
      margin-top: 20px;
      padding-top: 20px;
    }

    @media(max-width: 768px) {
      .detail-list {
        grid-template-columns: 1fr;
      }
    }

    .tracking-timeline {
      position: relative;
      margin-left: 25px;
    }

    .tracking-timeline::before {
      content: "";
      position: absolute;
      left: 12px;
      top: 0;
      width: 3px;
      height: 100%;
      background: #d6d6d6;
      border-radius: 2px;
    }

    .tracking-step {
      position: relative;
      padding-left: 45px;
      padding-bottom: 22px;
    }

    .tracking-step:last-child {
      padding-bottom: 0;
    }

    .tracking-step .icon {
      position: absolute;
      left: 0;
      top: -3px;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background: #bfbfbf;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 13px;
    }

    .tracking-step.active .icon {
      background: #0d6efd;
    }

    .tracking-step.done .icon {
      background: #28a745;
    }

    .tracking-step.cancel .icon {
      background: #dc3545;
    }

    .tracking-step small {
      color: #6c757d;
    }
  </style>
</head>

<body>

  <body class="loading">
    <div id="loader">
      <div class="spinner"></div>
    </div>
    <div id="content">

      <div class="hero text-center text-white">
        <h1 class="fw-bold mb-3">Lacak Pengiriman Anda</h1>
        <p class="mb-4">Masukkan nomor resi untuk mengetahui status barang Anda</p>

        <form class="search-box" method="get" action="">
          <div class="input-group input-group-lg">
            <input type="text" name="resi" class="form-control" placeholder="Contoh: RESI-4B82K9QXLA" value="<?= $_GET['resi'] ?>" required>
            <button class="btn btn-danger">Lacak</button>
          </div>
        </form>
      </div>

      <div class="container mt-5 mb-5">
        <?php if ($error): ?>
          <div class="alert alert-danger text-center tracking-result"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($shipment): ?>
          <div class="tracking-result">

            <div class="card shadow-sm mb-4 detail-card">
              <div class="card-body">

                <h5>Detail Pengiriman</h5>

                <div class="detail-list">
                  <div class="detail-item">
                    <label>Nomor Resi</label>
                    <p><?= $shipment->tracking_number ?></p>
                  </div>

                  <div class="detail-item">
                    <label>Status Saat Ini</label>
                    <?php
                    $badge = [
                      'Proses' => 'bg-warning text-dark',
                      'Dikirim' => 'bg-primary',
                      'Diterima' => 'bg-success',
                      'Batal' => 'bg-danger'
                    ];
                    ?>
                    <p>
                      <span class="badge <?= $badge[$shipment->status] ?? 'bg-secondary' ?> p-2">
                        <?= $shipment->status ?>
                      </span>
                    </p>
                  </div>

                  <div class="detail-item">
                    <label>Nama Barang</label>
                    <p><?= $shipment->item_name ?> (<?= $shipment->item_category ?>)</p>
                  </div>

                  <div class="detail-item">
                    <label>Jenis Layanan</label>
                    <p><?= $shipment->item_type ?></p>
                  </div>

                  <div class="detail-item">
                    <label>Biaya Pengiriman</label>
                    <p>Rp <?= number_format($shipment->shipping_cost, 0, ',', '.') ?></p>
                  </div>

                  <div class="detail-item">
                    <label>Telepon Penerima</label>
                    <p><?= $shipment->receiver_phone ?></p>
                  </div>
                </div>

                <div class="detail-section">
                  <h6 class="fw-bold mb-3">📦 Informasi Penerima</h6>
                  <p class="fw-semibold mb-1"><?= $shipment->receiver_name ?> — <?= $shipment->receiver_city ?></p>
                  <p class="text-muted"><?= $shipment->receiver_address ?></p>
                </div>
              </div>
            </div>

            <h5 class="fw-bold mb-4">📌 Timeline Pengiriman</h5>

            <div class="tracking-timeline">

              <div class="tracking-step <?= $shipment->status == 'Proses' ? 'active' : ($shipment->status != '' ? 'done' : '') ?>">
                <div class="icon"><i class="bi bi-box"></i></div>
                <strong>Barang sedang diproses di gudang</strong>
                <br><small>Status awal</small>
              </div>

              <div class="tracking-step <?= $shipment->status == 'Dikirim' ? 'active' : ($shipment->status == 'Diterima' ? 'done' : '') ?>">
                <div class="icon"><i class="bi bi-truck"></i></div>
                <strong>Barang dalam perjalanan menuju kota tujuan</strong>
                <br><small>Pengiriman oleh kurir</small>
              </div>

              <div class="tracking-step <?= $shipment->status == 'Diterima' ? 'done' : '' ?>">
                <div class="icon"><i class="bi bi-check-lg"></i></div>
                <strong>Barang telah diterima penerima</strong>
                <br><small>Pengiriman selesai</small>
              </div>

              <?php if ($shipment->status == 'Batal'): ?>
                <div class="tracking-step cancel">
                  <div class="icon"><i class="bi bi-x-lg"></i></div>
                  <strong>Pengiriman dibatalkan</strong>
                  <br><small>Dibatalkan oleh pengirim / CS</small>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <footer class="text-center text-muted mb-3">
        © <?= date('Y') ?> Cargo Tracking — All Rights Reserved
      </footer>
  </body>
  <script>
    window.addEventListener("load", function() {
      const loader = document.getElementById("loader");
      loader.style.opacity = "0";
      setTimeout(() => {
        loader.style.display = "none";
        document.body.classList.remove("loading");
      }, 300);
    });
  </script>

</html>