<?php

include 'config/koneksi.php';

$kategori = mysqli_query(
    $conn,
    "
    SELECT *
    FROM kategori
    ORDER BY nama_kategori ASC
",
);

// GENERATE KODE

$queryKode = mysqli_query(
    $conn,
    "
    SELECT MAX(kode_barang) as kodeTerbesar
    FROM barang
",
);

$dataKode = mysqli_fetch_assoc($queryKode);

$kodeBarang = $dataKode['kodeTerbesar'];

if ($kodeBarang) {
    $urutan = (int) substr($kodeBarang, 3, 3);
} else {
    $urutan = 0;
}

$urutan++;

$kode_barang = 'BRG' . sprintf('%03s', $urutan);

// SIMPAN

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori_id'];

    $nama_barang = htmlspecialchars($_POST['nama_barang']);

    $kapasitas = htmlspecialchars($_POST['kapasitas']);

    $harga_sewa = $_POST['harga_sewa'];

    $harga_tambah_hari = $_POST['harga_tambah_hari'];

    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // FOTO

    $foto = $_FILES['foto']['name'];

    $tmp = $_FILES['foto']['tmp_name'];

    $extension = pathinfo($foto, PATHINFO_EXTENSION);

    $namaFotoBaru = 'barang_' . time() . '.' . $extension;

    move_uploaded_file($tmp, 'uploads/barang/' . $namaFotoBaru);

    mysqli_query(
        $conn,
        "
        INSERT INTO barang (

            kode_barang,
            kategori_id,
            nama_barang,
            kapasitas,
            harga_sewa,
            harga_tambah_hari,
            deskripsi,
            foto

        ) VALUES (

            '$kode_barang',
            '$kategori_id',
            '$nama_barang',
            '$kapasitas',
            '$harga_sewa',
            '$harga_tambah_hari',
            '$deskripsi',
            '$namaFotoBaru'

        )
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

            Tambah Barang

        </h2>

        <p class="page-subtitle">

            Tambahkan perlengkapan rental baru

        </p>

    </div>

    <a href="index.php?page=barang" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<!-- FORM -->

<div class="card modern-card border-0">

    <div class="card-body p-4 p-lg-5">

        <form method="POST" enctype="multipart/form-data">

            <div class="row">

                <!-- LEFT -->

                <div class="col-lg-8">

                    <!-- KODE -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Kode Barang

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-upc-scan"></i>

                            </span>

                            <input type="text" class="form-control modern-input" value="<?= $kode_barang ?>"
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

                                <i class="bi bi-backpack2-fill"></i>

                            </span>

                            <input type="text" name="nama_barang" class="form-control modern-input"
                                placeholder="Masukkan nama barang" required>

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

                                <option value="<?= $k['id'] ?>">

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
                                placeholder="Contoh: 2 Orang">

                        </div>

                    </div>

                    <!-- HARGA -->

                    <div class="row">

                        <!-- 1 HARI -->

                        <div class="col-md-6">

                            <div class="mb-4">

                                <label class="form-label modern-label">

                                    Harga 1 Hari

                                </label>

                                <div class="input-group modern-input-group">

                                    <span class="input-group-text">

                                        Rp

                                    </span>

                                    <input type="number" name="harga_sewa" class="form-control modern-input"
                                        placeholder="0" required>

                                </div>

                            </div>

                        </div>

                        <!-- + HARI -->

                        <div class="col-md-6">

                            <div class="mb-4">

                                <label class="form-label modern-label">

                                    Harga + Hari

                                </label>

                                <div class="input-group modern-input-group">

                                    <span class="input-group-text">

                                        Rp

                                    </span>

                                    <input type="number" name="harga_tambah_hari" class="form-control modern-input"
                                        placeholder="0" required>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Deskripsi

                        </label>

                        <textarea name="deskripsi" class="form-control modern-textarea" rows="6"
                            placeholder="Masukkan deskripsi barang..."></textarea>

                    </div>

                </div>

                <!-- RIGHT -->

                <div class="col-lg-4">

                    <!-- FOTO -->

                    <div class="upload-card">

                        <div class="upload-title">

                            Foto Barang

                        </div>

                        <label class="upload-box">

                            <input type="file" name="foto" id="uploadFoto" hidden required>

                            <img src="https://via.placeholder.com/300x300?text=Preview" id="previewImage"
                                class="preview-image">

                            <div class="upload-placeholder">

                                <i class="bi bi-cloud-arrow-up-fill"></i>

                                <span>
                                    Upload Foto
                                </span>

                            </div>

                        </label>

                    </div>

                </div>

            </div>

            <!-- BUTTON -->

            <div class="d-flex gap-3 mt-4">

                <button type="submit" name="submit" class="btn btn-success btn-modern-submit">
                    <i class="bi bi-check-circle-fill me-2"></i>

                    Simpan Barang
                </button>

                <a href="index.php?page=barang" class="btn btn-light btn-modern-cancel">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

<!-- PREVIEW IMAGE -->

<script>
    document
        .getElementById('uploadFoto')
        .addEventListener('change', function(e) {

            const file =
                e.target.files[0];

            if (file) {

                document
                    .getElementById('previewImage')
                    .src =
                    URL.createObjectURL(file);

            }

        });
</script>
