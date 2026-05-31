<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT barang.*, kategori.nama_kategori
    FROM barang
    JOIN kategori ON barang.kategori_id = kategori.id
    ORDER BY barang.id DESC
",
);

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3>
        Data Barang
    </h3>

    <a href="index.php?page=barang-tambah" class="btn btn-dark">
        Tambah Barang
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Kapasitas</th>
                    <th>1 Hari</th>
                    <th>+ Hari</th>
                    <th width="20%">Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php
                $no = 1;

                while ($data = mysqli_fetch_assoc($query)) :
                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td>
                        <img src="uploads/barang/<?= $data['foto'] ?>" width="80">
                    </td>

                    <td><?= $data['kode_barang'] ?></td>

                    <td><?= $data['nama_barang'] ?></td>

                    <td><?= $data['nama_kategori'] ?></td>

                    <td><?= $data['kapasitas'] ?></td>

                    <td>
                        Rp <?= number_format($data['harga_sewa']) ?>
                    </td>

                    <td>
                        Rp <?= number_format($data['harga_tambah_hari']) ?>
                    </td>

                    <td>

                        <a href="index.php?page=barang-edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="index.php?page=barang-hapus&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus barang?')">
                            Hapus
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
