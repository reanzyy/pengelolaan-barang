<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userRole = $_SESSION['user']['role'] ?? '';

// Ambil file name halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-sm">
    <div class="app-brand d-flex justify-content-center p-2">
        <a href="" class="app-brand-link">
            <span class="app-brand-logo mt-3">
                <div class="fw-bold">
                    <span class="text-dark">SISTEM INFORMASI</span>
                    <br>PENGELOLAAN BARANG
                </div>
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <li class="menu-header">Menu Utama</li>
    <ul class="menu-inner py-1">

        <li class="menu-item <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
            <a href="./../../../pages/dashboard.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Beranda</div>
            </a>
        </li>

        <?php if ($userRole === 'courier') { ?>
            <li class="menu-header">Menu Kelola</li>
            <li class="menu-item <?= $current_page == 'index.php' && strpos($_SERVER['REQUEST_URI'], 'assigned') ? 'active' : '' ?>">
                <a href="./../../../pages/assigned/index.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-send"></i>
                    <div>Pengiriman Saya</div>
                </a>
            </li>
        <?php } ?>

        <?php if ($userRole === 'admin') { ?>
            <li class="menu-header">Menu Kelola</li>

            <li class="menu-item <?= strpos($_SERVER['REQUEST_URI'], 'senders') ? 'active' : '' ?>">
                <a href="./../../../pages/senders/index.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div>Pengirim</div>
                </a>
            </li>
            <li class="menu-item <?= strpos($_SERVER['REQUEST_URI'], 'receivers') ? 'active' : '' ?>">
                <a href="./../../../pages/receivers/index.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div>Penerima</div>
                </a>
            </li>
            <li class="menu-item <?= strpos($_SERVER['REQUEST_URI'], 'items') ? 'active' : '' ?>">
                <a href="./../../../pages/items/index.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-box"></i>
                    <div>Barang</div>
                </a>
            </li>
            <li class="menu-item <?= strpos($_SERVER['REQUEST_URI'], 'shipers') ? 'active' : '' ?>">
                <a href="./../../../pages/shipers/index.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-send"></i>
                    <div>Pengiriman</div>
                </a>
            </li>
            <li class="menu-item <?= strpos($_SERVER['REQUEST_URI'], 'users') ? 'active' : '' ?>">
                <a href="./../../../pages/users/index.php" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div>Pengguna</div>
                </a>
            </li>

            <li class="menu-header">Laporan</li>

            <?php
            $report_pages = ['daily.php', 'weekly.php', 'monthly.php', 'status.php'];
            $is_report = in_array($current_page, $report_pages);
            ?>
            <li class="menu-item <?= $is_report ? 'open active' : '' ?>">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-report"></i>
                    <div>Laporan Pengiriman</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item <?= $current_page == 'daily.php' ? 'active' : '' ?>">
                        <a href="./../../../pages/reports/daily.php" class="menu-link">
                            <div>Harian</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $current_page == 'weekly.php' ? 'active' : '' ?>">
                        <a href="./../../../pages/reports/weekly.php" class="menu-link">
                            <div>Mingguan</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $current_page == 'monthly.php' ? 'active' : '' ?>">
                        <a href="./../../../pages/reports/monthly.php" class="menu-link">
                            <div>Bulanan</div>
                        </a>
                    </li>
                    <li class="menu-item <?= $current_page == 'status.php' ? 'active' : '' ?>">
                        <a href="./../../../pages/reports/status.php" class="menu-link">
                            <div>Status</div>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>

        <li class="menu-header">Akun</li>
        <li class="menu-item <?= strpos($_SERVER['REQUEST_URI'], 'profile') ? 'active' : '' ?>">
            <a href="./../../../pages/profile/edit.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>Ubah Profile</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="./../../../pages/auth/logout.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-power-off"></i>
                <div>Log Out</div>
            </a>
        </li>
    </ul>
</aside>