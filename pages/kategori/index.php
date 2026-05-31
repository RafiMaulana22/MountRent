<?php

include 'config/koneksi.php';

$query = mysqli_query($conn, 'SELECT * FROM kategori ORDER BY id DESC');

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h3>
        Data Kategori
    </h3>

    <a href="index.php?page=kategori-tambah" class="btn btn-dark">
        Tambah Kategori
    </a>

</div>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>
                    <th width="5%">No</th>
                    <th>Nama Kategori</th>
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
                        <?= $data['nama_kategori'] ?>
                    </td>

                    <td>

                        <a href="index.php?page=kategori-edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="index.php?page=kategori-hapus&id=<?= $data['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus kategori?')">
                            Hapus
                        </a>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
