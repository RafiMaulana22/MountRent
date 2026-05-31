<?php

include 'config/koneksi.php';

if (isset($_POST['submit'])) {
    $nama_kategori = htmlspecialchars($_POST['nama_kategori']);

    mysqli_query(
        $conn,
        "INSERT INTO kategori (nama_kategori)
         VALUES ('$nama_kategori')",
    );

    header('Location: index.php?page=kategori');
    exit();
}

?>

<h3 class="mb-4">
    Tambah Kategori
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama Kategori
                </label>

                <input type="text" name="nama_kategori" class="form-control" required>

            </div>

            <button type="submit" name="submit" class="btn btn-dark">
                Simpan
            </button>

            <a href="index.php?page=kategori" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
