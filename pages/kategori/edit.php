<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM kategori WHERE id = '$id'");

$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $nama_kategori = htmlspecialchars($_POST['nama_kategori']);

    mysqli_query(
        $conn,
        "UPDATE kategori
         SET nama_kategori = '$nama_kategori'
         WHERE id = '$id'",
    );

    header('Location: index.php?page=kategori');
    exit();
}

?>

<h3 class="mb-4">
    Edit Kategori
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama Kategori
                </label>

                <input type="text" name="nama_kategori" class="form-control" value="<?= $data['nama_kategori'] ?>"
                    required>

            </div>

            <button type="submit" name="submit" class="btn btn-dark">
                Update
            </button>

            <a href="index.php?page=kategori" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
