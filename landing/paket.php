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
                Paket Rental Mendaki
            </h1>

            <p class="text-muted">
                Paket perlengkapan mendaki siap pakai
            </p>

        </div>

    </section>

    <!-- PAKET -->

    <section class="py-5">

        <div class="container">

            <div class="row">

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

                <div class="col-md-4 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <img src="../uploads/paket/<?= $data['foto'] ?>" class="card-img-top"
                            style="height:260px; object-fit:cover;">

                        <div class="card-body d-flex flex-column">

                            <h5 class="fw-bold">

                                <?= $data['nama_paket'] ?>

                            </h5>

                            <p class="text-muted">

                                Rp <?= number_format($data['harga_paket']) ?>

                            </p>

                            <div class="mb-3">

                                <small class="text-muted d-block mb-2">

                                    Isi Paket:

                                </small>

                                <?php while($d = mysqli_fetch_assoc($detail)) : ?>

                                <div class="small">

                                    • <?= $d['nama_barang'] ?>

                                    (<?= $d['jumlah'] ?>)

                                </div>

                                <?php endwhile; ?>

                            </div>

                            <a href="detail-paket.php?id=<?= $data['id'] ?>" class="btn btn-dark mt-auto">
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
