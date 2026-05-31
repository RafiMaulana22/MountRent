<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Kontak Rental - MountRent
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

        .contact-section {
            padding: 80px 0;
        }

        .contact-card {

            background: white;

            border-radius: 28px;

            padding: 40px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.06);
        }

        .contact-item {

            display: flex;
            align-items: start;

            gap: 18px;

            padding: 24px 0;

            border-bottom: 1px solid #e5e7eb;
        }

        .contact-item:last-child {
            border-bottom: none;
        }

        .contact-icon {

            width: 60px;
            height: 60px;

            background: #dcfce7;
            color: #166534;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 18px;

            font-size: 24px;

            flex-shrink: 0;
        }

        .contact-title {

            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .contact-text {

            color: #6b7280;
            line-height: 1.8;
        }

        .btn-wa {

            background: #16a34a;
            color: white;

            border-radius: 16px;

            padding: 14px 26px;

            font-weight: 600;

            transition: 0.3s;
        }

        .btn-wa:hover {

            background: #15803d;
            color: white;
        }

        .maps-box {

            overflow: hidden;

            border-radius: 28px;

            box-shadow:
                0 20px 50px rgba(0, 0, 0, 0.06);
        }

        iframe {

            width: 100%;
            height: 100%;

            min-height: 650px;

            border: 0;
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

                Kontak Rental

            </h1>

            <p class="hero-subtitle">

                Hubungi kami untuk informasi,
                pemesanan, dan konsultasi perlengkapan outdoor.

            </p>

        </div>

    </section>

    <!-- CONTACT -->

    <section class="contact-section">

        <div class="container">

            <div class="row g-4 align-items-stretch">

                <!-- INFO -->

                <div class="col-lg-5">

                    <div class="contact-card h-100">

                        <h2 class="fw-bold mb-4">

                            Informasi Kontak

                        </h2>

                        <!-- WHATSAPP -->

                        <div class="contact-item">

                            <div class="contact-icon">

                                <i class="bi bi-whatsapp"></i>

                            </div>

                            <div>

                                <div class="contact-title">

                                    WhatsApp

                                </div>

                                <div class="contact-text mb-3">

                                    0812-3456-7890

                                </div>

                                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-wa">
                                    Chat Sekarang
                                </a>

                            </div>

                        </div>

                        <!-- ALAMAT -->

                        <div class="contact-item">

                            <div class="contact-icon">

                                <i class="bi bi-geo-alt-fill"></i>

                            </div>

                            <div>

                                <div class="contact-title">

                                    Alamat Rental

                                </div>

                                <div class="contact-text">

                                    Jl. Pendaki Gunung No. 123<br>
                                    Surabaya, Jawa Timur

                                </div>

                            </div>

                        </div>

                        <!-- JAM -->

                        <div class="contact-item">

                            <div class="contact-icon">

                                <i class="bi bi-clock-fill"></i>

                            </div>

                            <div>

                                <div class="contact-title">

                                    Jam Operasional

                                </div>

                                <div class="contact-text">

                                    Senin - Minggu<br>
                                    08:00 - 21:00 WIB

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- MAPS -->

                <div class="col-lg-7">

                    <div class="maps-box h-100">

                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31687.720735104157!2d112.730876!3d-7.250445!2m3!1f0!2f0!3f0!"
                            allowfullscreen="" loading="lazy"></iframe>

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
