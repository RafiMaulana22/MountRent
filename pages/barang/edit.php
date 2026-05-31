<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");

$data = mysqli_fetch_assoc($query);

$kategori = mysqli_query($conn, 'SELECT * FROM kategori ORDER BY nama_kategori ASC');

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori_id'];
    $nama_barang = htmlspecialchars($_POST['nama_barang']);
    $kapasitas = htmlspecialchars($_POST['kapasitas']);
    $harga_sewa = $_POST['harga_sewa'];
    $harga_tambah_hari = $_POST['harga_tambah_hari'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $foto = $data['foto'];

    if ($_FILES['foto']['name'] != '') {
        if ($data['foto'] != '') {
            unlink('uploads/barang/' . $data['foto']);
        }

        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        $namaFotoBaru = 'barang_' . time() . '.' . $extension;

        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/barang/' . $namaFotoBaru);
        $foto = $namaFotoBaru;
    }

    mysqli_query($conn, "UPDATE barang SET kategori_id = '$kategori_id', nama_barang = '$nama_barang', kapasitas = '$kapasitas', harga_sewa = '$harga_sewa', harga_tambah_hari = '$harga_tambah_hari', deskripsi = '$deskripsi', foto = '$foto' WHERE id = '$id'");

    header('Location: index.php?page=barang');
    exit();
}

?>

<h3 class="mb-4">
    Edit Barang
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">
                    Kode Barang
                </label>

                <input type="text" class="form-control" value="<?= $data['kode_barang'] ?>" readonly>

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

                    <option value="<?= $k['id'] ?>" <?= $data['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                        <?= $k['nama_kategori'] ?>
                    </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Nama Barang
                </label>

                <input type="text" name="nama_barang" class="form-control" value="<?= $data['nama_barang'] ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Kapasitas
                </label>

                <input type="text" name="kapasitas" class="form-control" value="<?= $data['kapasitas'] ?>">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Harga Sewa
                </label>

                <input type="number" name="harga_sewa" class="form-control" value="<?= $data['harga_sewa'] ?>"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Harga Tambah Hari
                </label>

                <input type="number" name="harga_tambah_hari" class="form-control"
                    value="<?= $data['harga_tambah_hari'] ?>" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea name="deskripsi" class="form-control" rows="4"><?= $data['deskripsi'] ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label d-block">
                    Foto Lama
                </label>

                <img src="uploads/barang/<?= $data['foto'] ?>" width="120" class="mb-3 rounded">

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

            <a href="index.php?page=barang" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
