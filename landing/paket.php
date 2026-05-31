<?php

include '../config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM paket_rental
    ORDER BY id DESC
",
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Paket Rental - MountRent
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

            padding-top: 140px;
            padding-bottom: 80px;

            background:
                linear-gradient(rgba(0, 0, 0, 0.68),
                    rgba(0, 0, 0, 0.68)),
                url('../uploads/hero.jpg');

            background-size: cover;
            background-position: center;

            color: white;
        }

        .hero-title {
            font-size: 52px;
            font-weight: 700;
        }

        .hero-subtitle {
            color: #d1d5db;
            font-size: 17px;
        }

        .search-box {

            background: white;
            border-radius: 18px;
            padding: 10px 20px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .search-input {

            border: none;
            outline: none;
            width: 100%;
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
        }

        .card-custom {

            border: none;
            border-radius: 24px;
            overflow: hidden;
            background: white;

            transition: 0.3s;
        }

        .card-custom:hover {

            transform: translateY(-8px);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .card-img-top {

            height: 270px;
            object-fit: cover;
        }

        .price {

            color: #16a34a;
            font-size: 24px;
            font-weight: 700;
        }

        .item-list {

            background: #f9fafb;

            border-radius: 18px;

            padding: 18px;
        }

        .item-package {

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 10px 0;

            border-bottom: 1px solid #e5e7eb;
        }

        .item-package:last-child {
            border-bottom: none;
        }

        .item-qty {

            background: #dcfce7;
            color: #166534;

            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            font-size: 13px;
            font-weight: 700;
        }

        .btn-detail {

            background: #111827;
            color: white;

            border-radius: 14px;

            padding: 12px;

            font-weight: 600;

            transition: 0.3s;
        }

        .btn-detail:hover {

            background: #16a34a;
            color: white;
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

                <a href="index.php" class="btn btn-outline-light rounded-pill px-4">
                    Home
                </a>

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

    <section class="hero-mini">

        <div class="container text-center">

            <h1 class="hero-title mb-3">

                Paket Rental Outdoor

            </h1>

            <p class="hero-subtitle mb-5">

                Paket perlengkapan mendaki lengkap,
                praktis, dan siap digunakan.

            </p>

            <!-- SEARCH -->

            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <div class="search-box d-flex align-items-center">

                        <i class="bi bi-search text-muted me-3"></i>

                        <input type="text" id="searchInput" class="search-input" placeholder="Cari paket rental...">

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- PAKET -->

    <section class="py-5">

        <div class="container py-5">

            <div class="mb-5">

                <h2 class="section-title mb-2">

                    Semua Paket Rental

                </h2>

                <p class="text-muted">

                    Paket lengkap untuk pengalaman
                    mendaki lebih praktis dan nyaman.

                </p>

            </div>

            <div class="row" id="paketContainer">

                <?php while($data = mysqli_fetch_assoc($query)) : ?>

                <?php

                $detail = mysqli_query(
                    $conn,
                    "
                                        SELECT
                                            barang.nama_barang,
                                            paket_detail.jumlah

                                        FROM paket_detail

                                        JOIN barang
                                        ON paket_detail.barang_id = barang.id

                                        WHERE paket_detail.paket_id = '" .
                        $data['id'] .
                        "'
                                    ",
                );

                ?>

                <div class="col-lg-4 col-md-6 mb-4 paket-item" data-name="<?= strtolower($data['nama_paket']) ?>">

                    <div class="card card-custom h-100">

                        <img src="../uploads/paket/<?= $data['foto'] ?>" class="card-img-top">

                        <div class="card-body p-4 d-flex flex-column">

                            <div class="price mb-3">

                                Rp <?= number_format($data['harga_paket']) ?>

                            </div>

                            <h4 class="fw-bold mb-4">

                                <?= $data['nama_paket'] ?>

                            </h4>

                            <div class="item-list mb-4">

                                <?php while($d = mysqli_fetch_assoc($detail)) : ?>

                                <div class="item-package">

                                    <div class="small fw-medium">

                                        <?= $d['nama_barang'] ?>

                                    </div>

                                    <div class="item-qty">

                                        <?= $d['jumlah'] ?>

                                    </div>

                                </div>

                                <?php endwhile; ?>

                            </div>

                            <a href="detail-paket.php?id=<?= $data['id'] ?>" class="btn btn-detail mt-auto">
                                <i class="bi bi-eye-fill"></i>
                                Detail Paket
                            </a>

                        </div>

                    </div>

                </div>

                <?php endwhile; ?>

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

    <!-- SEARCH -->

    <script>
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('keyup', function() {

            let value = this.value.toLowerCase();

            let items = document.querySelectorAll('.paket-item');

            items.forEach(item => {

                let name = item.dataset.name;

                if (name.includes(value)) {

                    item.style.display = 'block';

                } else {

                    item.style.display = 'none';
                }

            });

        });
    </script>

</body>

</html>
