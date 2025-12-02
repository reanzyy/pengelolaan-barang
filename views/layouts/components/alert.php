<?php if (isset($_GET['message'])) : ?>
  <?php $message = $_GET['message']; ?>

  <?php if ($message === 'store') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data berhasil ditambahkan
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php elseif ($message === 'update') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data berhasil diubah
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php elseif ($message === 'delete') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data berhasil dihapus
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php elseif ($message === 'assigned_success') : ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      <strong>Kurir Ditugaskan!</strong> Pengiriman berhasil diberikan ke kurir.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php elseif ($message === 'already_assigned') : ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Sudah Ditugaskan!</strong> Pengiriman ini sebelumnya sudah memiliki kurir.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php endif ?>
<?php endif ?>