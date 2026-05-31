<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM barang
    WHERE id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

$kategori = mysqli_query(
    $conn,
    "
    SELECT *
    FROM kategori
    ORDER BY nama_kategori ASC
",
);

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori_id'];

    $nama_barang = htmlspecialchars($_POST['nama_barang']);

    $kapasitas = htmlspecialchars($_POST['kapasitas']);

    $harga_sewa = $_POST['harga_sewa'];

    $harga_tambah_hari = $_POST['harga_tambah_hari'];

    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    $foto = $data['foto'];

    // UPLOAD FOTO BARU

    if ($_FILES['foto']['name'] != '') {
        // HAPUS FOTO LAMA

        if ($data['foto'] != '') {
            unlink('uploads/barang/' . $data['foto']);
        }

        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        $namaFotoBaru = 'barang_' . time() . '.' . $extension;

        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/barang/' . $namaFotoBaru);

        $foto = $namaFotoBaru;
    }

    mysqli_query(
        $conn,
        "
        UPDATE barang
        SET

            kategori_id = '$kategori_id',
            nama_barang = '$nama_barang',
            kapasitas = '$kapasitas',
            harga_sewa = '$harga_sewa',
            harga_tambah_hari = '$harga_tambah_hari',
            deskripsi = '$deskripsi',
            foto = '$foto'

        WHERE id = '$id'
    ",
    );

    echo "
        <script>
            window.location.href =
                'index.php?page=barang';
        </script>
    ";

    exit();
}

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Edit Barang

        </h2>

        <p class="page-subtitle">

            Perbarui data perlengkapan rental outdoor

        </p>

    </div>

    <a href="index.php?page=barang" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<!-- FORM -->

<form method="POST" enctype="multipart/form-data">

    <div class="row g-4">

        <!-- LEFT -->

        <div class="col-lg-8">

            <div class="card modern-card border-0 h-100">

                <div class="card-body p-4 p-lg-5">

                    <!-- KODE -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Kode Barang

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-upc-scan"></i>

                            </span>

                            <input type="text" class="form-control modern-input" value="<?= $data['kode_barang'] ?>"
                                readonly>

                        </div>

                    </div>

                    <!-- NAMA -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Nama Barang

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-backpack-fill"></i>

                            </span>

                            <input type="text" name="nama_barang" class="form-control modern-input"
                                value="<?= $data['nama_barang'] ?>" placeholder="Masukkan nama barang" required>

                        </div>

                    </div>

                    <!-- KATEGORI -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Kategori

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-tags-fill"></i>

                            </span>

                            <select name="kategori_id" class="form-select modern-input" required>

                                <option value="">
                                    -- Pilih Kategori --
                                </option>

                                <?php while($k = mysqli_fetch_assoc($kategori)) : ?>

                                <option value="<?= $k['id'] ?>"
                                    <?= $data['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                                    <?= $k['nama_kategori'] ?>
                                </option>

                                <?php endwhile; ?>

                            </select>

                        </div>

                    </div>

                    <!-- KAPASITAS -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Kapasitas

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-people-fill"></i>

                            </span>

                            <input type="text" name="kapasitas" class="form-control modern-input"
                                value="<?= $data['kapasitas'] ?>" placeholder="Contoh: 2 Orang">

                        </div>

                    </div>

                    <!-- HARGA -->

                    <div class="row">

                        <!-- 1 HARI -->

                        <div class="col-md-6 mb-4">

                            <label class="form-label modern-label">

                                Harga 1 Hari

                            </label>

                            <div class="input-group modern-input-group">

                                <span class="input-group-text">

                                    Rp

                                </span>

                                <input type="number" name="harga_sewa" class="form-control modern-input"
                                    value="<?= $data['harga_sewa'] ?>" required>

                            </div>

                        </div>

                        <!-- + HARI -->

                        <div class="col-md-6 mb-4">

                            <label class="form-label modern-label">

                                Harga + Hari

                            </label>

                            <div class="input-group modern-input-group">

                                <span class="input-group-text">

                                    Rp

                                </span>

                                <input type="number" name="harga_tambah_hari" class="form-control modern-input"
                                    value="<?= $data['harga_tambah_hari'] ?>" required>

                            </div>

                        </div>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Deskripsi

                        </label>

                        <textarea name="deskripsi" class="form-control modern-textarea" rows="6"
                            placeholder="Masukkan deskripsi barang..."><?= $data['deskripsi'] ?></textarea>

                    </div>

                    <!-- BUTTON -->

                    <div class="d-flex gap-3">

                        <button type="submit" name="submit" class="btn btn-success btn-modern-submit">
                            <i class="bi bi-check-circle-fill me-2"></i>

                            Update Barang
                        </button>

                        <a href="index.php?page=barang" class="btn btn-light btn-modern-cancel">
                            Batal
                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="col-lg-4">

            <div class="upload-card">

                <h5 class="upload-title">

                    Foto Barang

                </h5>

                <label for="foto" class="upload-box">

                    <!-- PREVIEW -->

                    <img id="previewImage" src="uploads/barang/<?= $data['foto'] ?>" class="preview-image">

                    <!-- OVERLAY -->

                    <div class="upload-placeholder">

                        <i class="bi bi-cloud-arrow-up-fill"></i>

                        <span>
                            Ganti Foto
                        </span>

                    </div>

                </label>

                <input type="file" name="foto" id="foto" class="d-none" accept="image/*">

            </div>

        </div>

    </div>

</form>

<!-- PREVIEW IMAGE -->

<script>
    document
        .getElementById('foto')
        .addEventListener('change', function(e) {

            const file =
                e.target.files[0];

            if (file) {

                const reader =
                    new FileReader();

                reader.onload = function(event) {

                    document.getElementById(
                            'previewImage'
                        ).src =
                        event.target.result;
                };

                reader.readAsDataURL(file);
            }

        });
</script>
