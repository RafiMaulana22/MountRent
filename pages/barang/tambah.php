<?php

include 'config/koneksi.php';

$kategori = mysqli_query($conn, 'SELECT * FROM kategori ORDER BY nama_kategori ASC');

$queryKode = mysqli_query($conn, 'SELECT MAX(kode_barang) as kodeTerbesar FROM barang');

$dataKode = mysqli_fetch_assoc($queryKode);

$kodeBarang = $dataKode['kodeTerbesar'];

if ($kodeBarang) {
    $urutan = (int) substr($kodeBarang, 3, 3);

    $urutan++;
} else {
    $urutan = 1;
}

$kode_barang = 'BRG' . sprintf('%03s', $urutan);

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori_id'];
    $nama_barang = htmlspecialchars($_POST['nama_barang']);
    $kapasitas = htmlspecialchars($_POST['kapasitas']);
    $harga_sewa = $_POST['harga_sewa'];
    $harga_tambah_hari = $_POST['harga_tambah_hari'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $extension = pathinfo($foto, PATHINFO_EXTENSION);

    $namaFotoBaru = 'barang_' . time() . '.' . $extension;

    move_uploaded_file($tmp, 'uploads/barang/' . $namaFotoBaru);

    mysqli_query($conn, "INSERT INTO barang (kode_barang, kategori_id, nama_barang, kapasitas, harga_sewa, harga_tambah_hari, deskripsi, foto) VALUES ('$kode_barang', '$kategori_id', '$nama_barang', '$kapasitas', '$harga_sewa', '$harga_tambah_hari', '$deskripsi', '$namaFotoBaru')");

    header('Location: index.php?page=barang');
    exit();
}
?>

<h3 class="mb-4">
    Tambah Barang
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">
                    Kode Barang
                </label>

                <input type="text" class="form-control" value="<?= $kode_barang ?>" readonly>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Kategori
                </label>

                <select name="kategori_id" class="form-select" required>

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    <?php while($k = mysqli_fetch_assoc($kategori)) : ?>

                    <option value="<?= $k['id'] ?>">
                        <?= $k['nama_kategori'] ?>
                    </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nama Barang
                </label>

                <input type="text" name="nama_barang" class="form-control" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Kapasitas
                </label>

                <input type="text" name="kapasitas" class="form-control">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Harga Sewa
                </label>

                <input type="number" name="harga_sewa" class="form-control" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Harga Tambah Hari
                </label>

                <input type="number" name="harga_tambah_hari" class="form-control" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="deskripsi" class="form-control" rows="4"></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Foto Barang
                </label>

                <input type="file" name="foto" class="form-control" required>

            </div>

            <button type="submit" name="submit" class="btn btn-dark">
                Simpan
            </button>

            <a href="index.php?page=barang" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
