<?php

include 'config/koneksi.php';

$query = mysqli_query($conn, 'SELECT * FROM penyewa ORDER BY id DESC');

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3>
        Data Penyewa
    </h3>

    <a href="index.php?page=penyewa-tambah" class="btn btn-dark">
        Tambah Penyewa
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>
                    <th width="5%">No</th>
                    <th>Nama Penyewa</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Catatan</th>
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

                    <td><?= $data['nama'] ?></td>

                    <td><?= $data['no_hp'] ?></td>

                    <td><?= $data['alamat'] ?></td>

                    <td><?= $data['catatan'] ?></td>

                    <td>

                        <a href="index.php?page=penyewa-edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="index.php?page=penyewa-hapus&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus penyewa?')">
                            Hapus
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
