<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM paket_rental WHERE id = '$id'");

$data = mysqli_fetch_assoc($query);

$barang = mysqli_query($conn, 'SELECT * FROM barang ORDER BY nama_barang ASC');

$detail = mysqli_query(
    $conn,
    "
    SELECT *
    FROM paket_detail
    WHERE paket_id = '$id'
",
);

$barangDipilih = [];

while ($d = mysqli_fetch_assoc($detail)) {
    $barangDipilih[$d['barang_id']] = $d['jumlah'];
}

if (isset($_POST['submit'])) {
    $nama_paket = htmlspecialchars($_POST['nama_paket']);
    $harga_paket = $_POST['harga_paket'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $foto = $data['foto'];

    if ($_FILES['foto']['name'] != '') {
        if ($data['foto'] != '') {
            unlink('uploads/paket/' . $data['foto']);
        }

        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        $namaFotoBaru = 'paket_' . time() . '.' . $extension;

        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/paket/' . $namaFotoBaru);

        $foto = $namaFotoBaru;
    }

    mysqli_query(
        $conn,
        "
        UPDATE paket_rental SET
            nama_paket = '$nama_paket',
            harga_paket = '$harga_paket',
            deskripsi = '$deskripsi',
            foto = '$foto'
        WHERE id = '$id'
    ",
    );

    mysqli_query($conn, "DELETE FROM paket_detail WHERE paket_id = '$id'");

    if (isset($_POST['barang'])) {
        foreach ($_POST['barang'] as $barang_id => $value) {
            $jumlah = $_POST['jumlah'][$barang_id];

            mysqli_query(
                $conn,
                "
                INSERT INTO paket_detail (
                    paket_id,
                    barang_id,
                    jumlah
                ) VALUES (
                    '$id',
                    '$barang_id',
                    '$jumlah'
                )
            ",
            );
        }
    }

    header('Location: index.php?page=paket');
    exit();
}

?>

<h3 class="mb-4">
    Edit Paket Rental
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">
                    Nama Paket
                </label>

                <input type="text" name="nama_paket" class="form-control" value="<?= $data['nama_paket'] ?>" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Harga Paket
                </label>

                <input type="number" name="harga_paket" class="form-control" value="<?= $data['harga_paket'] ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="deskripsi" class="form-control" rows="4"><?= $data['deskripsi'] ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Pilih Barang
                </label>

                <?php while($b = mysqli_fetch_assoc($barang)) : ?>

                <?php
                $checked = isset($barangDipilih[$b['id']]);
                $jumlah = $checked ? $barangDipilih[$b['id']] : 1;
                ?>

                <div class="border rounded p-3 mb-2">

                    <div class="form-check mb-2">

                        <input type="checkbox" name="barang[<?= $b['id'] ?>]" value="<?= $b['id'] ?>"
                            class="form-check-input" <?= $checked ? 'checked' : '' ?>>

                        <label class="form-check-label">

                            <?= $b['nama_barang'] ?>

                        </label>

                    </div>

                    <input type="number" name="jumlah[<?= $b['id'] ?>]" class="form-control" min="1"
                        value="<?= $jumlah ?>">

                </div>

                <?php endwhile; ?>

            </div>

            <div class="mb-3">

                <label class="form-label d-block">
                    Foto Lama
                </label>

                <img src="uploads/paket/<?= $data['foto'] ?>" width="120" class="rounded mb-3">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Ganti Foto
                </label>

                <input type="file" name="foto" class="form-control">

            </div>

            <button type="submit" name="submit" class="btn btn-dark">
                Update
            </button>

            <a href="index.php?page=paket" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
