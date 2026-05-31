<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM paket_rental
    WHERE id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

$barang = mysqli_query(
    $conn,
    "
    SELECT *
    FROM barang
    ORDER BY nama_barang ASC
",
);

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

    // FOTO BARU

    if ($_FILES['foto']['name'] != '') {
        if ($data['foto'] != '') {
            unlink('uploads/paket/' . $data['foto']);
        }

        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

        $namaFotoBaru = 'paket_' . time() . '.' . $extension;

        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/paket/' . $namaFotoBaru);

        $foto = $namaFotoBaru;
    }

    // UPDATE PAKET

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

    // RESET DETAIL

    mysqli_query(
        $conn,
        "
        DELETE FROM paket_detail
        WHERE paket_id = '$id'
    ",
    );

    // INSERT DETAIL BARU

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

    echo "
        <script>
            window.location.href =
                'index.php?page=paket';
        </script>
    ";

    exit();
}

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Edit Paket Rental

        </h2>

        <p class="page-subtitle">

            Perbarui data paket rental outdoor

        </p>

    </div>

    <a href="index.php?page=paket" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<!-- FORM -->

<form method="POST" enctype="multipart/form-data">

    <div class="row g-4">

        <!-- LEFT -->

        <div class="col-lg-8">

            <div class="card modern-card border-0">

                <div class="card-body p-4 p-lg-5">

                    <!-- NAMA -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Nama Paket

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-box2-heart-fill"></i>

                            </span>

                            <input type="text" name="nama_paket" class="form-control modern-input"
                                value="<?= $data['nama_paket'] ?>" required>

                        </div>

                    </div>

                    <!-- HARGA -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Harga Paket

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                Rp

                            </span>

                            <input type="number" name="harga_paket" class="form-control modern-input"
                                value="<?= $data['harga_paket'] ?>" required>

                        </div>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Deskripsi Paket

                        </label>

                        <textarea name="deskripsi" class="form-control modern-textarea" rows="5"><?= $data['deskripsi'] ?></textarea>

                    </div>

                    <!-- ISI PAKET -->

                    <div class="mb-4">

                        <label class="form-label modern-label mb-3">

                            Isi Paket

                        </label>

                        <div class="package-selection">

                            <?php while($b = mysqli_fetch_assoc($barang)) : ?>

                            <?php

                            $checked = isset($barangDipilih[$b['id']]);

                            $jumlah = $checked ? $barangDipilih[$b['id']] : 1;

                            ?>

                            <div class="package-item-card">

                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- CHECKBOX -->

                                    <div class="form-check d-flex align-items-center gap-3">

                                        <input type="checkbox" name="barang[<?= $b['id'] ?>]" value="<?= $b['id'] ?>"
                                            class="form-check-input package-checkbox" id="barang<?= $b['id'] ?>"
                                            <?= $checked ? 'checked' : '' ?>>

                                        <label class="form-check-label package-label" for="barang<?= $b['id'] ?>">

                                            <div class="package-icon">

                                                <i class="bi bi-backpack-fill"></i>

                                            </div>

                                            <div>

                                                <div class="package-name">

                                                    <?= $b['nama_barang'] ?>

                                                </div>

                                                <small class="package-category">

                                                    <?= $b['kapasitas'] ?>

                                                </small>

                                            </div>

                                        </label>

                                    </div>

                                    <!-- JUMLAH -->

                                    <div class="package-qty">

                                        <label class="qty-label">

                                            Jumlah

                                        </label>

                                        <input type="number" name="jumlah[<?= $b['id'] ?>]"
                                            class="form-control qty-input" min="1" value="<?= $jumlah ?>">

                                    </div>

                                </div>

                            </div>

                            <?php endwhile; ?>

                        </div>

                    </div>

                    <!-- BUTTON -->

                    <div class="d-flex gap-3 mt-4">

                        <button type="submit" name="submit" class="btn btn-success btn-modern-submit">
                            <i class="bi bi-check-circle-fill me-2"></i>

                            Update Paket
                        </button>

                        <a href="index.php?page=paket" class="btn btn-light btn-modern-cancel">
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

                    Foto Paket

                </h5>

                <label for="foto" class="upload-box">

                    <img id="previewImage" src="uploads/paket/<?= $data['foto'] ?>" class="preview-image">

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

<!-- PREVIEW -->

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

                    document
                        .getElementById('previewImage')
                        .src =
                        event.target.result;
                };

                reader.readAsDataURL(file);

            }

        });
</script>
