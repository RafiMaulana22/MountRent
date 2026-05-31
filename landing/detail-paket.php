<?php

include '../config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM paket_rental
    WHERE id = '$id'
"
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
"
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

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a class="navbar-brand" href="index.php">
                MountRent
            </a>

            <div>

                <a
                    href="paket.php"
                    class="btn btn-outline-light me-2"
                >
                    Paket
                </a>

                <a
                    href="../auth/login.php"
                    class="btn btn-light"
                >
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

                    <img
                        src="../uploads/paket/<?= $data['foto'] ?>"
                        class="img-fluid rounded shadow-sm w-100"
                        style="height:500px; object-fit:cover;"
                    >

                </div>

                <!-- DETAIL -->

                <div class="col-md-6">

                    <h1 class="fw-bold mb-3">

                        <?= $data['nama_paket'] ?>

                    </h1>

                    <div class="mb-4">

                        <div class="fs-3 fw-bold text-dark">

                            Rp <?= number_format($data['harga_paket']) ?>

                        </div>

                    </div>

                    <div class="mb-4">

                        <h5 class="fw-bold">
                            Deskripsi Paket
                        </h5>

                        <p class="text-muted">

                            <?= nl2br($data['deskripsi']) ?>

                        </p>

                    </div>

                    <div class="mb-4">

                        <h5 class="fw-bold mb-3">
                            Isi Paket
                        </h5>

                        <div class="card border-0 bg-light">

                            <div class="card-body">

                                <?php while($d = mysqli_fetch_assoc($detail)) : ?>

                                    <div class="d-flex justify-content-between border-bottom py-2">

                                        <div>

                                            <?= $d['nama_barang'] ?>

                                        </div>

                                        <div>

                                            x<?= $d['jumlah'] ?>

                                        </div>

                                    </div>

                                <?php endwhile; ?>

                            </div>

                        </div>

                    </div>

                    <a
                        href="paket.php"
                        class="btn btn-outline-dark"
                    >
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
