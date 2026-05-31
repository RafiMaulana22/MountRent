<?php

session_start();

// Jika belum login → tampil landing
if (!isset($_SESSION['login'])) {

    header('Location: landing/index.php');
    exit();
}

// Jika sudah login → masuk admin

$page = $_GET['page'] ?? 'dashboard';

$halaman = [

    // Dashboard
    'dashboard' => 'pages/dashboard/index.php',

    // Kategori
    'kategori' => 'pages/kategori/index.php',
    'kategori-tambah' => 'pages/kategori/tambah.php',
    'kategori-edit' => 'pages/kategori/edit.php',
    'kategori-hapus' => 'pages/kategori/hapus.php',

    // Barang
    'barang' => 'pages/barang/index.php',
    'barang-tambah' => 'pages/barang/tambah.php',
    'barang-edit' => 'pages/barang/edit.php',
    'barang-hapus' => 'pages/barang/hapus.php',

    // Paket Rental
    'paket' => 'pages/paket/index.php',
    'paket-tambah' => 'pages/paket/tambah.php',
    'paket-edit' => 'pages/paket/edit.php',
    'paket-hapus' => 'pages/paket/hapus.php',

    // Penyewa
    'penyewa' => 'pages/penyewa/index.php',
    'penyewa-tambah' => 'pages/penyewa/tambah.php',
    'penyewa-edit' => 'pages/penyewa/edit.php',
    'penyewa-hapus' => 'pages/penyewa/hapus.php',

    // Transaksi
    'transaksi' => 'pages/transaksi/index.php',
    'transaksi-tambah' => 'pages/transaksi/tambah.php',
    'transaksi-detail' => 'pages/transaksi/detail.php',
    'transaksi-hapus' => 'pages/transaksi/hapus.php',

    // Riwayat
    'riwayat' => 'pages/riwayat/index.php',
    'riwayat-detail' => 'pages/riwayat/detail.php',

    // Laporan
    'laporan' => 'pages/laporan/index.php',
    'laporan-pendapatan' => 'pages/laporan/pendapatan.php',
    'laporan-barang' => 'pages/laporan/barang.php',
    'laporan-print-pendapatan' => 'pages/laporan/print-pendapatan.php',
    'laporan-print-barang' => 'pages/laporan/print-barang.php',

    // Pengaturan
    'pengaturan' => 'pages/pengaturan/index.php',
];

?>

<?php include 'includes/header.php'; ?>

<?php include 'includes/navbar.php'; ?>

<div class="wrapper">

    <?php include 'includes/sidebar.php'; ?>

    <div class="content">

        <?php

        if (array_key_exists($page, $halaman)) {

            include $halaman[$page];

        } else {

            echo "
                <div class='alert alert-danger'>
                    Halaman tidak ditemukan
                </div>
            ";
        }

        ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>
