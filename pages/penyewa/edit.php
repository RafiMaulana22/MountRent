<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM penyewa
    WHERE id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);

    $no_hp = htmlspecialchars($_POST['no_hp']);

    $alamat = htmlspecialchars($_POST['alamat']);

    $catatan = htmlspecialchars($_POST['catatan']);

    mysqli_query(
        $conn,
        "
        UPDATE penyewa SET

            nama = '$nama',
            no_hp = '$no_hp',
            alamat = '$alamat',
            catatan = '$catatan'

        WHERE id = '$id'
    ",
    );

    echo "
        <script>
            window.location.href =
                'index.php?page=penyewa';
        </script>
    ";

    exit();
}

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Edit Penyewa

        </h2>

        <p class="page-subtitle">

            Perbarui data pelanggan rental outdoor

        </p>

    </div>

    <a href="index.php?page=penyewa" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<!-- FORM -->

<div class="card modern-card border-0">

    <div class="card-body p-4 p-lg-5">

        <form method="POST">

            <div class="row">

                <!-- LEFT -->

                <div class="col-lg-8">

                    <!-- NAMA -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Nama Penyewa

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-person-fill"></i>

                            </span>

                            <input type="text" name="nama" class="form-control modern-input"
                                value="<?= $data['nama'] ?>" placeholder="Masukkan nama penyewa" required>

                        </div>

                    </div>

                    <!-- NO HP -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Nomor HP

                        </label>

                        <div class="input-group modern-input-group">

                            <span class="input-group-text">

                                <i class="bi bi-telephone-fill"></i>

                            </span>

                            <input type="text" name="no_hp" class="form-control modern-input"
                                value="<?= $data['no_hp'] ?>" placeholder="08xxxxxxxxxx">

                        </div>

                    </div>

                    <!-- ALAMAT -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Alamat

                        </label>

                        <div class="input-group modern-input-group textarea-group">

                            <span class="input-group-text textarea-icon">

                                <i class="bi bi-geo-alt-fill"></i>

                            </span>

                            <textarea name="alamat" class="form-control modern-textarea" rows="4" placeholder="Masukkan alamat penyewa..."><?= $data['alamat'] ?></textarea>

                        </div>

                    </div>

                    <!-- CATATAN -->

                    <div class="mb-4">

                        <label class="form-label modern-label">

                            Catatan

                        </label>

                        <div class="input-group modern-input-group textarea-group">

                            <span class="input-group-text textarea-icon">

                                <i class="bi bi-journal-text"></i>

                            </span>

                            <textarea name="catatan" class="form-control modern-textarea" rows="4"
                                placeholder="Tambahkan catatan tambahan..."><?= $data['catatan'] ?></textarea>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->

                <div class="col-lg-4">

                    <div class="penyewa-profile-card">

                        <div class="profile-avatar">

                            <?= strtoupper(substr($data['nama'], 0, 1)) ?>

                        </div>

                        <h5 class="profile-title">

                            <?= $data['nama'] ?>

                        </h5>

                        <p class="profile-subtitle">

                            Perbarui informasi pelanggan rental agar data tetap akurat dan mudah digunakan saat
                            transaksi penyewaan.

                        </p>

                        <div class="profile-info-box">

                            <div class="info-item">

                                <i class="bi bi-telephone-fill"></i>

                                <?= $data['no_hp'] != '' ? $data['no_hp'] : 'Belum ada nomor HP' ?>

                            </div>

                            <div class="info-item">

                                <i class="bi bi-geo-alt-fill"></i>

                                Data Penyewa Aktif
                            </div>

                            <div class="info-item">

                                <i class="bi bi-pencil-square"></i>

                                Edit Data Penyewa
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- BUTTON -->

            <div class="d-flex gap-3 mt-4">

                <button type="submit" name="submit" class="btn btn-success btn-modern-submit">
                    <i class="bi bi-check-circle-fill me-2"></i>

                    Update Penyewa
                </button>

                <a href="index.php?page=penyewa" class="btn btn-light btn-modern-cancel">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
