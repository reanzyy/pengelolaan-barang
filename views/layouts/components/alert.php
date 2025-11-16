<?php if (isset($_GET['message'])) : ?>
  <?php $message = $_GET['message']; ?>
  <?php if ($message === 'store') : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data berhasil ditambahkan
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php elseif ($message === 'update'): ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data berhasil diubah
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php elseif ($message === 'delete'): ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> Data berhasil dihapus
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

  <?php endif ?>

<?php endif ?>