<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM kategori
    WHERE id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $nama_kategori = htmlspecialchars($_POST['nama_kategori']);

    mysqli_query(
        $conn,
        "
        UPDATE kategori
        SET nama_kategori = '$nama_kategori'
        WHERE id = '$id'
    ",
    );

    echo "
            <script>

                window.location =
                    'index.php?page=kategori';

            </script>
        ";

    exit();
}

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Edit Kategori

        </h2>

        <p class="page-subtitle">

            Perbarui data kategori perlengkapan rental

        </p>

    </div>

    <a href="index.php?page=kategori" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<!-- FORM CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4 p-lg-5">

        <form method="POST">

            <!-- INPUT -->

            <div class="mb-4">

                <label class="form-label modern-label">

                    Nama Kategori

                </label>

                <div class="input-group modern-input-group">

                    <span class="input-group-text">

                        <i class="bi bi-tags-fill"></i>

                    </span>

                    <input type="text" name="nama_kategori" class="form-control modern-input"
                        value="<?= $data['nama_kategori'] ?>" placeholder="Masukkan nama kategori" required>

                </div>

            </div>

            <!-- BUTTON -->

            <div class="d-flex gap-3">

                <button type="submit" name="submit" class="btn btn-warning btn-modern-submit text-white">
                    <i class="bi bi-check-circle-fill me-2"></i>

                    Update Kategori
                </button>

                <a href="index.php?page=kategori" class="btn btn-light btn-modern-cancel">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>
