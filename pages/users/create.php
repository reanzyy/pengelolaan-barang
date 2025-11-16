<?php
// function yang berada di folder app
require('./../../app/user.php');

// logic untuk create data
if (isset($_POST['submit'])) {
  if (store($_POST) > 0) {
    header('Location: index.php?message=store');
    exit;
  }
}

// breadcrumnd
$title = "Tambah Pengguna";
$items = [
  ['label' => 'Dashboard', 'url' => '../dashboard.php'],
  ['label' => 'Pengguna', 'url' => '../users/index.php'],
  ['label' => 'Tambah', 'url' => '']
];

include('./../../views/layouts/main-header.php');
?>

<div class="d-flex align-items-center justify-content-center row">
  <div class="col-sm-10">
    <div class="card">
      <div class="card-body">
        <form action="" method="post">
          <div class="card-body">
            <div class="form-group row mb-3">
              <label class="col-lg-3 col-form-label">Nama <span class="text-danger">*</span></label>
              <div class="col-lg-9">
                <input type="text" name="name" class="form-control" required>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-lg-3 col-form-label">Username <span class="text-danger">*</span></label>
              <div class="col-lg-9">
                <input type="text" name="username" class="form-control" required>
              </div>
            </div>
            <div class="form-group row mb-3">
              <label class="col-lg-3 col-form-label">Password <span class="text-danger">*</span></label>
              <div class="col-lg-9">
                <input type="password" name="password" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="card-footer text-end border-top">
            <span class="text-muted float-start">
              <strong class="text-danger">*</strong> Harus diisi
            </span>
            <div class="float-end">
              <a class="btn btn-secondary" href="index.php">Kembali</a>
              <button class="btn btn-primary" name="submit">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('./../../views/layouts/main-footer.php') ?>