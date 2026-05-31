<?php

include '../config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT
        barang.*,
        kategori.nama_kategori

    FROM barang

    JOIN kategori
    ON barang.kategori_id = kategori.id

    ORDER BY barang.id DESC
",
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Katalog Barang - MountRent
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
                Katalog Barang Rental
            </h1>

            <p class="text-muted">
                Perlengkapan mendaki lengkap dan siap digunakan
            </p>

        </div>

    </section>

    <!-- KATALOG -->

    <section class="py-5">

        <div class="container">

            <div class="row">

                <?php while($data = mysqli_fetch_assoc($query)) : ?>

                <div class="col-md-4 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <img src="../uploads/barang/<?= $data['foto'] ?>" class="card-img-top"
                            style="height:260px; object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <span class="badge bg-dark mb-2">

                                <?= $data['nama_kategori'] ?>

                            </span>

                            <h5 class="fw-bold">

                                <?= $data['nama_barang'] ?>

                            </h5>

                            <p class="text-muted small">

                                <?= $data['kapasitas'] ?>

                            </p>

                            <div class="mb-3">

                                <div class="fw-semibold">

                                    Rp <?= number_format($data['harga_sewa']) ?>

                                    / 1 Hari

                                </div>

                                <small class="text-muted">

                                    +Hari:
                                    Rp <?= number_format($data['harga_tambah_hari']) ?>

                                </small>

                            </div>

                            <a href="detail-barang.php?id=<?= $data['id'] ?>" class="btn btn-dark mt-auto">
                                Lihat Detail
                            </a>

                        </div>

                    </div>

                </div>

                <?php endwhile; ?>

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
