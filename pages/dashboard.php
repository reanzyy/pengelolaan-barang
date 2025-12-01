<?php
require('./../config.php');
require('./../app/middleware.php');

checkAuth();

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

<?php include('./../views/layouts/main-footer.php') ?>