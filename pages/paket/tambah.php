<?php

include 'config/koneksi.php';

$barang = mysqli_query($conn, 'SELECT * FROM barang ORDER BY nama_barang ASC');

if (isset($_POST['submit'])) {
    $nama_paket = htmlspecialchars($_POST['nama_paket']);
    $harga_paket = $_POST['harga_paket'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $extension = pathinfo($foto, PATHINFO_EXTENSION);

    $namaFotoBaru = 'paket_' . time() . '.' . $extension;

    move_uploaded_file($tmp, 'uploads/paket/' . $namaFotoBaru);

    mysqli_query(
        $conn,
        "
        INSERT INTO paket_rental (
            nama_paket,
            harga_paket,
            deskripsi,
            foto
        ) VALUES (
            '$nama_paket',
            '$harga_paket',
            '$deskripsi',
            '$namaFotoBaru'
        )
    ",
    );

    $paket_id = mysqli_insert_id($conn);

    if (isset($_POST['barang'])) {
        foreach ($_POST['barang'] as $barang_id) {
            $jumlah = $_POST['jumlah'][$barang_id];

            mysqli_query(
                $conn,
                "
            INSERT INTO paket_detail (
                paket_id,
                barang_id,
                jumlah
            ) VALUES (
                '$paket_id',
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
    Tambah Paket Rental
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">
                    Nama Paket
                </label>

                <input type="text" name="nama_paket" class="form-control" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Harga Paket
                </label>

                <input type="number" name="harga_paket" class="form-control" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="deskripsi" class="form-control" rows="4"></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Pilih Barang
                </label>

                <?php while($b = mysqli_fetch_assoc($barang)) : ?>

                <div class="border rounded p-3 mb-2">

                    <div class="form-check mb-2">

                        <input type="checkbox" name="barang[<?= $b['id'] ?>]" value="<?= $b['id'] ?>"
                            class="form-check-input">

                        <label class="form-check-label">

                            <?= $b['nama_barang'] ?>

                        </label>

                    </div>

                    <input type="number" name="jumlah[<?= $b['id'] ?>]" class="form-control" min="1"
                        value="1">

                </div>

                <?php endwhile; ?>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Foto Paket
                </label>

                <input type="file" name="foto" class="form-control" required>

            </div>

            <button type="submit" name="submit" class="btn btn-dark">
                Simpan
            </button>

            <a href="index.php?page=paket" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
