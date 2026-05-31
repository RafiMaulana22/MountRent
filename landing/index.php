<?php

include '../config/koneksi.php';

$barang = mysqli_query($conn, 'SELECT * FROM barang ORDER BY id DESC LIMIT 6');

$paket = mysqli_query($conn, 'SELECT * FROM paket_rental ORDER BY id DESC LIMIT 3');

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        MountRent
    </title>

    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icon -->

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
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
        }

        .hero {
            min-height: 100vh;
            background:
                linear-gradient(rgba(0, 0, 0, 0.65),
                    rgba(0, 0, 0, 0.65)),
                url('../uploads/hero.png');

            background-size: cover;
            background-position: center;

            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 64px;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 18px;
            color: #d1d5db;
            max-width: 700px;
            margin: auto;
        }

        .btn-custom {
            background: #16a34a;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background: #15803d;
            transform: translateY(-2px);
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .section-subtitle {
            color: #6b7280;
        }

        .card-custom {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            transition: 0.3s;
            background: white;
        }

        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .card-img-top {
            height: 260px;
            object-fit: cover;
        }

        .price {
            color: #16a34a;
            font-weight: 700;
            font-size: 20px;
        }

        .badge-category {
            background: #dcfce7;
            color: #166534;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
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

            <a class="navbar-brand fw-bold fs-4" href="#">
                <i class="bi bi-backpack2-fill"></i>
                MountRent
            </a>

            <div class="d-flex gap-2">

                <a href="katalog.php" class="btn btn-outline-light rounded-pill px-4">
                    Katalog
                </a>

                <a href="../auth/login.php" class="btn btn-light rounded-pill px-4">
                    Admin Login
                </a>

            </div>

        </div>

    </nav>

    <!-- HERO -->

    <section class="hero text-white text-center">

        <div class="container">

            <h1 class="hero-title mb-4">

                Rental Perlengkapan
                Mendaki Modern

            </h1>

            <p class="hero-subtitle mb-5">

                Sewa perlengkapan outdoor berkualitas
                untuk pengalaman pendakian yang aman,
                nyaman, dan menyenangkan.

            </p>

            <div class="d-flex justify-content-center gap-3">

                <a href="katalog.php" class="btn-custom text-decoration-none">

                    <i class="bi bi-grid-fill"></i>
                    Lihat Katalog

                </a>

                <a href="paket.php" class="btn btn-light rounded-4 px-4 py-3 fw-semibold">

                    <i class="bi bi-box-fill"></i>
                    Paket Rental

                </a>

            </div>

        </div>

    </section>

    <!-- KATALOG -->

    <section class="py-5">

        <div class="container py-5">

            <div class="text-center mb-5">

                <h2 class="section-title">
                    Perlengkapan Terbaru
                </h2>

                <p class="section-subtitle">
                    Peralatan outdoor terbaik dan siap digunakan
                </p>

            </div>

            <div class="row">

                <?php while($b = mysqli_fetch_assoc($barang)) : ?>

                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="card card-custom h-100">

                        <img src="../uploads/barang/<?= $b['foto'] ?>" class="card-img-top">

                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <span class="badge-category">

                                    Outdoor Gear

                                </span>

                                <span class="price">

                                    Rp <?= number_format($b['harga_sewa']) ?>

                                </span>

                            </div>

                            <h5 class="fw-bold mb-3">

                                <?= $b['nama_barang'] ?>

                            </h5>

                            <a href="detail-barang.php?id=<?= $b['id'] ?>" class="btn btn-dark rounded-4 w-100">
                                Lihat Detail
                            </a>

                        </div>

                    </div>

                </div>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

    <!-- PAKET -->

    <section class="py-5 bg-white">

        <div class="container py-5">

            <div class="text-center mb-5">

                <h2 class="section-title">
                    Paket Rental
                </h2>

                <p class="section-subtitle">
                    Paket lengkap untuk pendakian lebih praktis
                </p>

            </div>

            <div class="row">

                <?php while($p = mysqli_fetch_assoc($paket)) : ?>

                <div class="col-lg-4 mb-4">

                    <div class="card card-custom h-100">

                        <img src="../uploads/paket/<?= $p['foto'] ?>" class="card-img-top">

                        <div class="card-body p-4">

                            <div class="price mb-3">

                                Rp <?= number_format($p['harga_paket']) ?>

                            </div>

                            <h5 class="fw-bold mb-3">

                                <?= $p['nama_paket'] ?>

                            </h5>

                            <a href="detail-paket.php?id=<?= $p['id'] ?>" class="btn btn-dark rounded-4 w-100">
                                Detail Paket
                            </a>

                        </div>

                    </div>

                </div>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

    <!-- CTA -->

    <section class="py-5">

        <div class="container">

            <div class="bg-dark text-white rounded-5 p-5 text-center">

                <h2 class="fw-bold mb-3">

                    Siap Mendaki?

                </h2>

                <p class="mb-4 text-light">

                    Temukan perlengkapan terbaik
                    untuk perjalanan outdoor kamu.

                </p>

                <a href="kontak.php" class="btn btn-success rounded-4 px-4 py-3 fw-semibold">
                    Hubungi Kami
                </a>

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
