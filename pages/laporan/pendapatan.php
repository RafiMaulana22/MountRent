<?php

include 'config/koneksi.php';

$where = '';

$totalPendapatan = 0;

if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];

    if ($tanggal_awal != '' && $tanggal_akhir != '') {
        $where = "
            WHERE tanggal_sewa
            BETWEEN '$tanggal_awal'
            AND '$tanggal_akhir'
        ";
    }
}

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM transaksi
    $where
    ORDER BY id DESC
",
);

$totalPendapatan = 0;

$dataTotal = mysqli_query(
    $conn,
    "
    SELECT SUM(total) as grand_total
    FROM transaksi
    $where
",
);

$totalData = mysqli_fetch_assoc($dataTotal);

$totalPendapatan = $totalData['grand_total'] ?? 0;
?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Laporan Pendapatan

        </h2>

        <p class="page-subtitle">

            Analisis total pendapatan transaksi rental outdoor

        </p>

    </div>

    <a href="index.php?page=laporan" class="btn btn-light btn-back">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

</div>

<!-- FILTER -->

<div class="card modern-card border-0 mb-4">

    <div class="card-body p-4">

        <form method="GET">

            <input type="hidden" name="page" value="laporan-pendapatan">

            <div class="row g-4">

                <!-- TANGGAL AWAL -->

                <div class="col-lg-4">

                    <label class="form-label modern-label">

                        Tanggal Awal

                    </label>

                    <div class="input-group modern-input-group">

                        <span class="input-group-text">

                            <i class="bi bi-calendar-event"></i>

                        </span>

                        <input type="date" name="tanggal_awal" class="form-control modern-input"
                            value="<?= $_GET['tanggal_awal'] ?? '' ?>">

                    </div>

                </div>

                <!-- TANGGAL AKHIR -->

                <div class="col-lg-4">

                    <label class="form-label modern-label">

                        Tanggal Akhir

                    </label>

                    <div class="input-group modern-input-group">

                        <span class="input-group-text">

                            <i class="bi bi-calendar-check"></i>

                        </span>

                        <input type="date" name="tanggal_akhir" class="form-control modern-input"
                            value="<?= $_GET['tanggal_akhir'] ?? '' ?>">

                    </div>

                </div>

                <!-- BUTTON -->

                <div class="col-lg-4">

                    <label class="form-label opacity-0">
                        Action
                    </label>

                    <div class="d-flex gap-3">

                        <button type="submit" class="btn btn-success btn-modern-submit flex-grow-1">

                            <i class="bi bi-funnel-fill me-2"></i>

                            Filter

                        </button>

                        <a href="pages/laporan/print-pendapatan.php?tanggal_awal=<?= $_GET['tanggal_awal'] ?? '' ?>&tanggal_akhir=<?= $_GET['tanggal_akhir'] ?? '' ?>"
                            target="_blank" class="btn btn-dark btn-modern-print">

                            <i class="bi bi-printer-fill"></i>

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- TOTAL CARD -->

<div class="row mb-4">

    <div class="col-lg-4">

        <div class="income-summary-card">

            <div class="summary-icon">

                <i class="bi bi-cash-stack"></i>

            </div>

            <div>

                <div class="summary-label">

                    Total Pendapatan

                </div>

                <div class="summary-value">

                    Rp
                    <?= number_format($totalPendapatan) ?>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- TABLE -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tablePendapatan">

                <thead>

                    <tr>

                        <th width="8%">
                            No
                        </th>

                        <th>
                            Kode Transaksi
                        </th>

                        <th>
                            Tanggal Sewa
                        </th>

                        <th>
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    mysqli_data_seek($query, 0);

                    while ($data = mysqli_fetch_assoc($query)) :

                        $totalPendapatan += $data['total'];
                    ?>

                    <tr>

                        <td>

                            <span class="table-number">

                                <?= $no++ ?>

                            </span>

                        </td>

                        <td>

                            <div class="transaction-code">

                                <?= $data['kode_transaksi'] ?>

                            </div>

                        </td>

                        <td>

                            <div class="date-badge">

                                <i class="bi bi-calendar3 me-2"></i>

                                <?= date('d M Y', strtotime($data['tanggal_sewa'])) ?>

                            </div>

                        </td>

                        <td>

                            <div class="price-badge">

                                Rp
                                <?= number_format($data['total']) ?>

                            </div>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- DATATABLE -->

<script>
    $(document).ready(function() {

        $('#tablePendapatan').DataTable({

            responsive: true,

            pageLength: 10,

            language: {

                search: "_INPUT_",

                searchPlaceholder: "Cari transaksi...",

                lengthMenu: "Tampilkan _MENU_ data",

                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                paginate: {

                    previous: "‹",

                    next: "›"
                }
            }
        });

    });
</script>
