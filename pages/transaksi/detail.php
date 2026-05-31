<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT transaksi.*, penyewa.nama
    FROM transaksi
    JOIN penyewa ON transaksi.penyewa_id = penyewa.id
    WHERE transaksi.id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query(
    $conn,
    "
    SELECT
        detail_transaksi.*,
        barang.nama_barang,
        paket_rental.nama_paket
    FROM detail_transaksi

    LEFT JOIN barang
    ON detail_transaksi.barang_id = barang.id

    LEFT JOIN paket_rental
    ON detail_transaksi.paket_id = paket_rental.id

    WHERE transaksi_id = '$id'
",
);

?>

<h3 class="mb-4">
    Detail Transaksi
</h3>

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <table class="table">

            <tr>
                <th width="25%">Kode</th>
                <td><?= $data['kode_transaksi'] ?></td>
            </tr>

            <tr>
                <th>Penyewa</th>
                <td><?= $data['nama'] ?></td>
            </tr>

            <tr>
                <th>Tanggal Sewa</th>
                <td><?= $data['tanggal_sewa'] ?></td>
            </tr>

            <tr>
                <th>Tanggal Kembali</th>
                <td><?= $data['tanggal_kembali'] ?></td>
            </tr>

            <tr>
                <th>Total</th>
                <td>
                    Rp <?= number_format($data['total']) ?>
                </td>
            </tr>

        </table>

    </div>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Item</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Lama Hari</th>
                    <th>Subtotal</th>
                </tr>

            </thead>

            <tbody>

                <?php
                $no = 1;

                while($d = mysqli_fetch_assoc($detail)) :
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td>

                        <?= $d['nama_barang'] ?: $d['nama_paket'] ?>

                    </td>

                    <td>
                        Rp <?= number_format($d['harga']) ?>
                    </td>

                    <td><?= $d['jumlah'] ?></td>

                    <td><?= $d['lama_hari'] ?> Hari</td>

                    <td>
                        Rp <?= number_format($d['subtotal']) ?>
                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
