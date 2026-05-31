<?php

include 'config/koneksi.php';

$query = mysqli_query($conn, 'SELECT * FROM paket_rental ORDER BY id DESC');

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3>
        Paket Rental
    </h3>

    <a href="index.php?page=paket-tambah" class="btn btn-dark">
        Tambah Paket
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Paket</th>
                    <th>Isi Paket</th>
                    <th>Harga Paket</th>
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

                    <td>
                        <img src="uploads/paket/<?= $data['foto'] ?>" width="100">
                    </td>

                    <td><?= $data['nama_paket'] ?></td>

                    <td>

                        <?php

                        $detail = mysqli_query($conn, "SELECT barang.nama_barang, paket_detail.jumlah FROM paket_detail JOIN barang ON paket_detail.barang_id = barang.id WHERE paket_detail.paket_id = '" . $data['id'] . "'");

                        while ($d = mysqli_fetch_assoc($detail)) {
                            echo '- ' . $d['nama_barang'] . ' (' . $d['jumlah'] . ')<br>';
                        }

                        ?>

                    </td>

                    <td>
                        Rp <?= number_format($data['harga_paket']) ?>
                    </td>

                    <td>

                        <a href="index.php?page=paket-edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="index.php?page=paket-hapus&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus paket?')">
                            Hapus
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
