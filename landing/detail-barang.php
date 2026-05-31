<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT
        barang.*,
        kategori.nama_kategori

    FROM barang

    JOIN kategori
    ON barang.kategori_id = kategori.id

    WHERE barang.id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $data['nama_barang'] ?> - MountRent
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

                <a href="katalog.php" class="btn btn-outline-light me-2">
                    Katalog
                </a>

                <a href="../auth/login.php" class="btn btn-light">
                    Admin Login
                </a>

            </div>

        </div>

    </nav>

    <!-- DETAIL -->

    <section class="py-5">

        <div class="container">

            <div class="row">

                <!-- FOTO -->

                <div class="col-md-6 mb-4">

                    <img src="../uploads/barang/<?= $data['foto'] ?>" class="img-fluid rounded shadow-sm w-100"
                        style="height:500px; object-fit:cover;">

                </div>

                <!-- DETAIL -->

                <div class="col-md-6">

                    <span class="badge bg-dark mb-3">

                        <?= $data['nama_kategori'] ?>

                    </span>

                    <h1 class="fw-bold mb-3">

                        <?= $data['nama_barang'] ?>

                    </h1>

                    <p class="text-muted">

                        <?= $data['kapasitas'] ?>

                    </p>

                    <hr>

                    <div class="mb-3">

                        <h5 class="fw-bold">

                            Harga Sewa

                        </h5>

                        <div class="fs-4 fw-bold text-dark">

                            Rp <?= number_format($data['harga_sewa']) ?>

                            <small class="fs-6 fw-normal">

                                / 1 Hari

                            </small>

                        </div>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-semibold">

                            Harga Tambah Hari

                        </h6>

                        <div class="text-muted">

                            Rp <?= number_format($data['harga_tambah_hari']) ?>

                            / Hari

                        </div>

                    </div>

                    <div class="mb-4">

                        <h5 class="fw-bold">
                            Deskripsi
                        </h5>

                        <p class="text-muted">

                            <?= nl2br($data['deskripsi']) ?>

                        </p>

                    </div>

                    <a href="katalog.php" class="btn btn-outline-dark">
                        Kembali
                    </a>

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
