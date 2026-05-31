<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT transaksi.*, penyewa.nama
    FROM transaksi
    JOIN penyewa ON transaksi.penyewa_id = penyewa.id
    ORDER BY transaksi.id DESC
",
);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3>
        Transaksi Penyewaan
    </h3>

    <a href="index.php?page=transaksi-tambah" class="btn btn-dark">
        Tambah Transaksi
    </a>

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
                    <th width="20%">Aksi</th>
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

                        <a href="index.php?page=transaksi-detail&id=<?= $data['id'] ?>" class="btn btn-info btn-sm">
                            Detail
                        </a>

                        <a href="index.php?page=transaksi-hapus&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus transaksi?')">
                            Hapus
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
