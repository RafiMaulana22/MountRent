<?php

include 'config/koneksi.php';

$where = '';

if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    $tanggal_awal = $_GET['tanggal_awal'];

    $tanggal_akhir = $_GET['tanggal_akhir'];

    if ($tanggal_awal != '' && $tanggal_akhir != '') {
        $where = "
            WHERE transaksi.tanggal_sewa
            BETWEEN '$tanggal_awal'
            AND '$tanggal_akhir'
        ";
    }
}

$query = mysqli_query(
    $conn,
    "
    SELECT
        transaksi.*,
        penyewa.nama

    FROM transaksi

    JOIN penyewa
    ON transaksi.penyewa_id = penyewa.id

    $where

    ORDER BY transaksi.id DESC
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Riwayat Transaksi

        </h2>

        <p class="page-subtitle">

            Riwayat seluruh transaksi penyewaan perlengkapan outdoor

        </p>

    </div>

</div>

<!-- FILTER -->

<div class="card modern-card border-0 mb-4">

    <div class="card-body p-4">

        <form method="GET">

            <input type="hidden" name="page" value="riwayat">

            <div class="row g-4 align-items-end">

                <!-- TANGGAL AWAL -->

                <div class="col-lg-4">

                    <label class="form-label modern-label">

                        Tanggal Awal

                    </label>

                    <div class="input-group modern-input-group">

                        <span class="input-group-text">

                            <i class="bi bi-calendar-check-fill"></i>

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

                            <i class="bi bi-calendar2-week-fill"></i>

                        </span>

                        <input type="date" name="tanggal_akhir" class="form-control modern-input"
                            value="<?= $_GET['tanggal_akhir'] ?? '' ?>">

                    </div>

                </div>

                <!-- BUTTON -->

                <div class="col-lg-4">

                    <div class="d-flex gap-3">

                        <button type="submit" class="btn btn-success btn-modern-submit">
                            <i class="bi bi-funnel-fill me-2"></i>

                            Filter
                        </button>

                        <a href="index.php?page=riwayat" class="btn btn-light btn-modern-cancel">
                            Reset
                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- TABLE -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tableRiwayat">

                <thead>

                    <tr>

                        <th width="5%">
                            No
                        </th>

                        <th>
                            Kode
                        </th>

                        <th>
                            Penyewa
                        </th>

                        <th>
                            Tanggal Sewa
                        </th>

                        <th>
                            Tanggal Kembali
                        </th>

                        <th>
                            Total
                        </th>

                        <th width="12%">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while($data = mysqli_fetch_assoc($query)) :
                    ?>

                    <tr>

                        <!-- NO -->

                        <td>

                            <span class="table-number">

                                <?= $no++ ?>

                            </span>

                        </td>

                        <!-- KODE -->

                        <td>

                            <div class="transaction-code">

                                <i class="bi bi-receipt-cutoff"></i>

                                <?= $data['kode_transaksi'] ?>

                            </div>

                        </td>

                        <!-- PENYEWA -->

                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="penyewa-avatar">

                                    <?= strtoupper(substr($data['nama'], 0, 1)) ?>

                                </div>

                                <div>

                                    <div class="fw-bold text-dark">

                                        <?= $data['nama'] ?>

                                    </div>

                                    <small class="text-muted">

                                        Customer Rental

                                    </small>

                                </div>

                            </div>

                        </td>

                        <!-- TANGGAL SEWA -->

                        <td>

                            <div class="date-box-modern">

                                <i class="bi bi-calendar-check-fill"></i>

                                <?= date('d M Y', strtotime($data['tanggal_sewa'])) ?>

                            </div>

                        </td>

                        <!-- TANGGAL KEMBALI -->

                        <td>

                            <div class="date-box-modern return-date">

                                <i class="bi bi-calendar2-week-fill"></i>

                                <?= date('d M Y', strtotime($data['tanggal_kembali'])) ?>

                            </div>

                        </td>

                        <!-- TOTAL -->

                        <td>

                            <div class="price-box">

                                Rp <?= number_format($data['total']) ?>

                            </div>

                        </td>

                        <!-- AKSI -->

                        <td>

                            <a href="
                                    index.php?page=riwayat-detail&id=<?= $data['id'] ?>
                                "
                                class="btn btn-info btn-action">
                                <i class="bi bi-eye-fill"></i>
                            </a>

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

        let table =
            $('#tableRiwayat').DataTable({

                responsive: true,

                autoWidth: false,

                pageLength: 10,

                language: {

                    search: "_INPUT_",

                    searchPlaceholder: "Cari riwayat transaksi...",

                    lengthMenu: "Tampilkan _MENU_ data",

                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                    paginate: {

                        previous: "‹",

                        next: "›"
                    }
                }

            });

        // FIX RESPONSIVE

        $('#toggleSidebar').on('click', function() {

            setTimeout(function() {

                table.columns.adjust().responsive.recalc();

            }, 300);

        });

    });
</script>
