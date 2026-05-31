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
    SELECT transaksi.*, penyewa.nama
    FROM transaksi

    JOIN penyewa
    ON transaksi.penyewa_id = penyewa.id

    $where

    ORDER BY transaksi.id DESC
",
);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3>
        Riwayat Transaksi
    </h3>

</div>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET">

            <input type="hidden" name="page" value="riwayat">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Tanggal Awal
                    </label>

                    <input type="date" name="tanggal_awal" class="form-control"
                        value="<?= $_GET['tanggal_awal'] ?? '' ?>">

                </div>

                <div class="col-md-4 mb-3">

                    <label class="form-label">
                        Tanggal Akhir
                    </label>

                    <input type="date" name="tanggal_akhir" class="form-control"
                        value="<?= $_GET['tanggal_akhir'] ?? '' ?>">

                </div>

                <div class="col-md-4 d-flex align-items-end mb-3">

                    <button type="submit" class="btn btn-dark me-2">
                        Filter
                    </button>

                    <a href="index.php?page=riwayat" class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Penyewa</th>
                    <th>Tanggal Sewa</th>
                    <th>Tanggal Kembali</th>
                    <th>Total</th>
                    <th width="15%">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php
                $no = 1;

                while($data = mysqli_fetch_assoc($query)) :
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $data['kode_transaksi'] ?></td>

                    <td><?= $data['nama'] ?></td>

                    <td><?= $data['tanggal_sewa'] ?></td>

                    <td><?= $data['tanggal_kembali'] ?></td>

                    <td>
                        Rp <?= number_format($data['total']) ?>
                    </td>

                    <td>

                        <a href="index.php?page=riwayat-detail&id=<?= $data['id'] ?>" class="btn btn-info btn-sm">
                            Detail
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
