<?php

$currentPage = $_GET['page'] ?? 'dashboard';

?>

<div class="sidebar" id="sidebar">

    <!-- LOGO -->

    <div class="sidebar-brand">

        <div class="brand-icon">

            <i class="bi bi-backpack2-fill"></i>

        </div>

        <div>

            <h4 class="brand-title">

                MountRent

            </h4>

            <small class="brand-subtitle">

                Admin Panel

            </small>

        </div>

    </div>

    <!-- MENU -->

    <div class="sidebar-menu">

        <!-- DASHBOARD -->

        <a href="index.php?page=dashboard" class="menu-item <?= $currentPage == 'dashboard' ? 'active' : '' ?>">
            <i class="bi bi-grid-fill"></i>

            <span>
                Dashboard
            </span>
        </a>

        <!-- KATEGORI -->

        <a href="index.php?page=kategori"
            class="menu-item <?= strpos($currentPage, 'kategori') !== false ? 'active' : '' ?>">
            <i class="bi bi-tags-fill"></i>

            <span>
                Kategori
            </span>
        </a>

        <!-- BARANG -->

        <a href="index.php?page=barang"
            class="menu-item <?= strpos($currentPage, 'barang') !== false ? 'active' : '' ?>">
            <i class="bi bi-backpack-fill"></i>

            <span>
                Barang
            </span>
        </a>

        <!-- PAKET -->

        <a href="index.php?page=paket" class="menu-item <?= strpos($currentPage, 'paket') !== false ? 'active' : '' ?>">
            <i class="bi bi-box2-heart-fill"></i>

            <span>
                Paket Rental
            </span>
        </a>

        <!-- PENYEWA -->

        <a href="index.php?page=penyewa"
            class="menu-item <?= strpos($currentPage, 'penyewa') !== false ? 'active' : '' ?>">
            <i class="bi bi-people-fill"></i>

            <span>
                Penyewa
            </span>
        </a>

        <!-- TRANSAKSI -->

        <a href="index.php?page=transaksi"
            class="menu-item <?= strpos($currentPage, 'transaksi') !== false ? 'active' : '' ?>">
            <i class="bi bi-receipt-cutoff"></i>

            <span>
                Transaksi
            </span>
        </a>

        <!-- RIWAYAT -->

        <a href="index.php?page=riwayat"
            class="menu-item <?= strpos($currentPage, 'riwayat') !== false ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i>

            <span>
                Riwayat
            </span>
        </a>

        <!-- LAPORAN -->

        <a href="index.php?page=laporan"
            class="menu-item <?= strpos($currentPage, 'laporan') !== false ? 'active' : '' ?>">
            <i class="bi bi-bar-chart-fill"></i>

            <span>
                Laporan
            </span>
        </a>

        <!-- PENGATURAN -->

        <!-- <a href="index.php?page=pengaturan"
            class="menu-item <?= strpos($currentPage, 'pengaturan') !== false ? 'active' : '' ?>">
            <i class="bi bi-gear-fill"></i>

            <span>
                Pengaturan
            </span>
        </a> -->

    </div>

    <!-- FOOTER -->

    <div class="sidebar-footer">

        <a href="auth/logout.php" class="logout-btn">
            <i class="bi bi-box-arrow-left"></i>

            <span>
                Logout
            </span>
        </a>

    </div>

</div>
