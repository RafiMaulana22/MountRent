<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM penyewa WHERE id = '$id'");

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

    header('Location: index.php?page=penyewa');
    exit();
}

?>

<h3 class="mb-4">
    Edit Penyewa
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama Penyewa
                </label>

                <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    No HP
                </label>

                <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp'] ?>">

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Alamat
                </label>

                <textarea name="alamat" class="form-control" rows="3"><?= $data['alamat'] ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Catatan
                </label>

                <textarea name="catatan" class="form-control" rows="3"><?= $data['catatan'] ?></textarea>

            </div>

            <button type="submit" name="submit" class="btn btn-dark">
                Update
            </button>

            <a href="index.php?page=penyewa" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>
