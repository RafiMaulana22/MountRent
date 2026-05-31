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

?>

<h3 class="mb-4">
    Laporan Pendapatan
</h3>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <input type="hidden" name="page" value="laporan-pendapatan">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Tanggal Awal
                    </label>

                    <input type="date" name="tanggal_awal" class="form-control">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Tanggal Akhir
                    </label>

                    <input type="date" name="tanggal_akhir" class="form-control">

                </div>

                <div class="col-md-4 d-flex align-items-end mb-3">

                    <button type="submit" class="btn btn-dark me-2">
                        Filter
                    </button>

                    <a href="index.php?page=laporan-print-pendapatan&tanggal_awal=<?= $_GET['tanggal_awal'] ?? '' ?>&tanggal_akhir=<?= $_GET['tanggal_akhir'] ?? '' ?>"
                        target="_blank" class="btn btn-success">
                        Print
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                </tr>

            </thead>

            <tbody>

                <?php
                $no = 1;

                while($data = mysqli_fetch_assoc($query)) :

                    $totalPendapatan += $data['total'];
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $data['kode_transaksi'] ?></td>

                    <td><?= $data['tanggal_sewa'] ?></td>

                    <td>
                        Rp <?= number_format($data['total']) ?>
                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

            <tfoot>

                <tr>

                    <th colspan="3">
                        Total Pendapatan
                    </th>

                    <th>
                        Rp <?= number_format($totalPendapatan) ?>
                    </th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>
