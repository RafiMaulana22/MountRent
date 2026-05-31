<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Kontak - MountRent
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand" href="index.php">
                MountRent
            </a>

            <div>

                <a href="index.php" class="btn btn-outline-light me-2">
                    Home
                </a>

                <a href="../auth/login.php" class="btn btn-light">
                    Admin Login
                </a>

            </div>

        </div>

    </nav>

    <!-- HEADER -->

    <section class="bg-light py-5">

        <div class="container text-center">

            <h1 class="fw-bold">
                Kontak Rental
            </h1>

            <p class="text-muted">
                Hubungi kami untuk informasi dan pemesanan
            </p>

        </div>

    </section>

    <!-- KONTAK -->

    <section class="py-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-4">

                            <div class="mb-4">

                                <h5 class="fw-bold">
                                    WhatsApp
                                </h5>

                                <p class="text-muted mb-2">
                                    0812-3456-7890
                                </p>

                                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-success">
                                    Chat WhatsApp
                                </a>

                            </div>

                            <hr>

                            <div class="mb-4">

                                <h5 class="fw-bold">
                                    Alamat Rental
                                </h5>

                                <p class="text-muted mb-0">

                                    Jl. Pendaki Gunung No. 123
                                    Surabaya, Jawa Timur

                                </p>

                            </div>

                            <hr>

                            <div class="mb-4">

                                <h5 class="fw-bold">
                                    Jam Operasional
                                </h5>

                                <p class="text-muted mb-0">

                                    Senin - Minggu
                                    08:00 - 21:00

                                </p>

                            </div>

                            <hr>

                            <div>

                                <h5 class="fw-bold mb-3">
                                    Lokasi Maps
                                </h5>

                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31687.720735104157!2d112.730876!3d-7.250445!2m3!1f0!2f0!3f0!"
                                    width="100%" height="350" style="border:0;" allowfullscreen=""
                                    loading="lazy"></iframe>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer class="bg-dark text-white text-center py-4">

        <div class="container">

            <p class="mb-1">
                © <?= date('Y') ?> MountRent
            </p>

            <small>
                Rental Perlengkapan Mendaki
            </small>

        </div>

    </footer>

</body>

</html>
