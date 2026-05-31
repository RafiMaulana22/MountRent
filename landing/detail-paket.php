<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM paket_rental
    WHERE id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query(
    $conn,
    "
    SELECT
        barang.nama_barang,
        paket_detail.jumlah

    FROM paket_detail

    JOIN barang
    ON paket_detail.barang_id = barang.id

    WHERE paket_detail.paket_id = '$id'
",
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $data['nama_paket'] ?> - MountRent
    </title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f7fa;
            color: #1f2937;
        }

        .navbar {
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(10px);
        }

        .hero-mini {

            padding-top: 130px;
            padding-bottom: 60px;

            background:
                linear-gradient(rgba(0, 0, 0, 0.65),
                    rgba(0, 0, 0, 0.65)),
                url('../uploads/hero.jpg');

            background-size: cover;
            background-position: center;

            color: white;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 700;
        }

        .hero-subtitle {
            color: #d1d5db;
        }

        .detail-section {
            padding: 80px 0;
        }

        .product-image {

            width: 100%;
            height: 600px;

            object-fit: cover;

            border-radius: 28px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .detail-card {

            background: white;

            border-radius: 28px;

            padding: 40px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.06);
        }

        .badge-package {

            background: #dcfce7;
            color: #166534;

            padding: 10px 18px;

            border-radius: 999px;

            font-size: 13px;
            font-weight: 600;
        }

        .product-title {

            font-size: 42px;
            font-weight: 700;
        }

        .price-main {

            color: #16a34a;

            font-size: 40px;
            font-weight: 700;
        }

        .package-box {

            background: #f9fafb;

            border-radius: 20px;

            padding: 24px;
        }

        .package-item {

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 14px 0;

            border-bottom: 1px solid #e5e7eb;
        }

        .package-item:last-child {
            border-bottom: none;
        }

        .item-qty {

            width: 36px;
            height: 36px;

            background: #dcfce7;
            color: #166534;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-size: 13px;
            font-weight: 700;
        }

        .description-box {

            background: white;

            border-radius: 20px;

            padding: 30px;

            margin-top: 30px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.04);
        }

        .btn-custom {

            background: #111827;
            color: white;

            border-radius: 16px;

            padding: 14px 24px;

            font-weight: 600;

            transition: 0.3s;
        }

        .btn-custom:hover {

            background: #16a34a;
            color: white;
        }

        .btn-outline-custom {

            border-radius: 16px;

            padding: 14px 24px;

            font-weight: 600;
        }

        footer {
            background: #0f172a;
        }

        .footer-link {

            color: #d1d5db;
            text-decoration: none;
        }

        .footer-link:hover {
            color: white;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">

        <div class="container">

            <a class="navbar-brand fw-bold fs-4" href="index.php">

                <i class="bi bi-backpack2-fill"></i>
                MountRent

            </a>

            <div class="d-flex gap-2">

                <a href="katalog.php" class="btn btn-outline-light rounded-pill px-4">
                    Katalog
                </a>

                <a href="paket.php" class="btn btn-outline-light rounded-pill px-4">
                    Paket
                </a>

                <a href="../auth/login.php" class="btn btn-light rounded-pill px-4">
                    Admin Login
                </a>

            </div>

        </div>

    </nav>

    <!-- HERO -->

    <section class="hero-mini text-center">

        <div class="container">

            <h1 class="hero-title mb-3">

                Detail Paket Rental

            </h1>

            <p class="hero-subtitle">

                Paket perlengkapan outdoor lengkap
                dan siap digunakan.

            </p>

        </div>

    </section>

    <!-- DETAIL -->

    <section class="detail-section">

        <div class="container">

            <div class="row align-items-start">

                <!-- IMAGE -->

                <div class="col-lg-6 mb-4">

                    <img src="../uploads/paket/<?= $data['foto'] ?>" class="product-image">

                </div>

                <!-- DETAIL -->

                <div class="col-lg-6">

                    <div class="detail-card">

                        <span class="badge-package mb-4 d-inline-block">

                            Outdoor Package

                        </span>

                        <h1 class="product-title mb-3">

                            <?= $data['nama_paket'] ?>

                        </h1>

                        <div class="price-main mb-4">

                            Rp <?= number_format($data['harga_paket']) ?>

                        </div>

                        <!-- PACKAGE CONTENT -->

                        <div class="package-box mb-4">

                            <h5 class="fw-bold mb-4">

                                Isi Paket

                            </h5>

                            <?php while($d = mysqli_fetch_assoc($detail)) : ?>

                            <div class="package-item">

                                <div class="fw-medium">

                                    <?= $d['nama_barang'] ?>

                                </div>

                                <div class="item-qty">

                                    <?= $d['jumlah'] ?>

                                </div>

                            </div>

                            <?php endwhile; ?>

                        </div>

                        <!-- BUTTON -->

                        <div class="d-flex gap-3">

                            <a href="paket.php" class="btn btn-outline-dark btn-outline-custom">
                                <i class="bi bi-arrow-left"></i>
                                Kembali
                            </a>

                            <a href="kontak.php" class="btn btn-custom">
                                <i class="bi bi-whatsapp"></i>
                                Hubungi Rental
                            </a>

                        </div>

                    </div>

                    <!-- DESCRIPTION -->

                    <div class="description-box">

                        <h4 class="fw-bold mb-3">

                            Deskripsi Paket

                        </h4>

                        <p class="text-muted mb-0 lh-lg">

                            <?= nl2br($data['deskripsi']) ?>

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer class="text-white py-5">

        <div class="container">

            <div class="row">

                <div class="col-md-6 mb-4">

                    <h4 class="fw-bold mb-3">

                        MountRent

                    </h4>

                    <p class="text-light">

                        Rental perlengkapan mendaki modern,
                        aman, dan terpercaya.

                    </p>

                </div>

                <div class="col-md-6 text-md-end">

                    <h5 class="fw-semibold mb-3">
                        Navigasi
                    </h5>

                    <div class="d-flex flex-column">

                        <a href="index.php" class="footer-link mb-2">
                            Home
                        </a>

                        <a href="katalog.php" class="footer-link mb-2">
                            Katalog
                        </a>

                        <a href="paket.php" class="footer-link mb-2">
                            Paket
                        </a>

                        <a href="kontak.php" class="footer-link">
                            Kontak
                        </a>

                    </div>

                </div>

            </div>

            <hr class="border-secondary">

            <div class="text-center text-light">

                © <?= date('Y') ?> MountRent

            </div>

        </div>

    </footer>

</body>

</html>
