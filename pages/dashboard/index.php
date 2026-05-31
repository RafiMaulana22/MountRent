<?php

include 'config/koneksi.php';

/* =========================
   TOTAL DATA
========================= */

$totalBarang = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM barang'));

$totalPaket = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM paket_rental'));

$totalPenyewa = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM penyewa'));

$totalTransaksi = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM transaksi'));

/* =========================
   TOTAL PENDAPATAN
========================= */

$pendapatan = mysqli_query(
    $conn,
    "
    SELECT SUM(total) as total_pendapatan
    FROM transaksi
",
);

$dataPendapatan = mysqli_fetch_assoc($pendapatan);

/* =========================
   TRANSAKSI TERBARU
========================= */

$transaksi = mysqli_query(
    $conn,
    "
    SELECT
        transaksi.*,
        penyewa.nama

    FROM transaksi

    JOIN penyewa
    ON transaksi.penyewa_id = penyewa.id

    ORDER BY transaksi.id DESC

    LIMIT 5
",
);

?>

<!-- PAGE TITLE -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">
            Dashboard Admin
        </h2>

        <p class="text-muted mb-0">
            Selamat datang kembali,
            <?= $_SESSION['nama_lengkap'] ?>
        </p>

    </div>

</div>

<!-- STATISTIC -->

<div class="row g-4 mb-4">

    <!-- BARANG -->

    <div class="col-md-3">

        <div class="dashboard-card">

            <div class="card-icon bg-primary-subtle text-primary">

                <i class="bi bi-backpack2-fill"></i>

            </div>

            <div>

                <h3 class="fw-bold mb-1">

                    <?= $totalBarang ?>

                </h3>

                <p class="text-muted mb-0">

                    Total Barang

                </p>

            </div>

        </div>

    </div>

    <!-- PAKET -->

    <div class="col-md-3">

        <div class="dashboard-card">

            <div class="card-icon bg-success-subtle text-success">

                <i class="bi bi-box2-heart-fill"></i>

            </div>

            <div>

                <h3 class="fw-bold mb-1">

                    <?= $totalPaket ?>

                </h3>

                <p class="text-muted mb-0">

                    Paket Rental

                </p>

            </div>

        </div>

    </div>

    <!-- PENYEWA -->

    <div class="col-md-3">

        <div class="dashboard-card">

            <div class="card-icon bg-warning-subtle text-warning">

                <i class="bi bi-people-fill"></i>

            </div>

            <div>

                <h3 class="fw-bold mb-1">

                    <?= $totalPenyewa ?>

                </h3>

                <p class="text-muted mb-0">

                    Penyewa

                </p>

            </div>

        </div>

    </div>

    <!-- TRANSAKSI -->

    <div class="col-md-3">

        <div class="dashboard-card">

            <div class="card-icon bg-danger-subtle text-danger">

                <i class="bi bi-receipt-cutoff"></i>

            </div>

            <div>

                <h3 class="fw-bold mb-1">

                    <?= $totalTransaksi ?>

                </h3>

                <p class="text-muted mb-0">

                    Transaksi

                </p>

            </div>

        </div>

    </div>

</div>

<!-- PENDAPATAN -->

<div class="row g-4 mb-4">

    <div class="col-md-12">

        <div class="income-card">

            <div>

                <p class="income-label mb-2">

                    Total Pendapatan

                </p>

                <h1 class="income-value">

                    Rp <?= number_format($dataPendapatan['total_pendapatan'] ?? 0) ?>

                </h1>

            </div>

            <div class="income-icon">

                <i class="bi bi-cash-stack"></i>

            </div>

        </div>

    </div>

</div>

<!-- TRANSAKSI TERBARU -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h5 class="fw-bold mb-1">
                    Transaksi Terbaru
                </h5>

                <small class="text-muted">
                    Data transaksi penyewaan terbaru
                </small>

            </div>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>
                        <th>Kode</th>
                        <th>Penyewa</th>
                        <th>Tanggal Sewa</th>
                        <th>Total</th>
                    </tr>

                </thead>

                <tbody>

                    <?php while($t = mysqli_fetch_assoc($transaksi)) : ?>

                    <tr>

                        <td>

                            <span class="badge bg-dark">

                                <?= $t['kode_transaksi'] ?>

                            </span>

                        </td>

                        <td>

                            <?= $t['nama'] ?>

                        </td>

                        <td>

                            <?= date('d M Y', strtotime($t['tanggal_sewa'])) ?>

                        </td>

                        <td class="fw-semibold text-success">

                            Rp <?= number_format($t['total']) ?>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
