<?php

include 'config/koneksi.php';

if (isset($_POST['submit'])) {

    $nama     = htmlspecialchars($_POST['nama']);
    $no_hp    = htmlspecialchars($_POST['no_hp']);
    $alamat   = htmlspecialchars($_POST['alamat']);
    $catatan  = htmlspecialchars($_POST['catatan']);

    mysqli_query(
        $conn,
        "
        INSERT INTO penyewa (
            nama,
            no_hp,
            alamat,
            catatan
        ) VALUES (
            '$nama',
            '$no_hp',
            '$alamat',
            '$catatan'
        )
    "
    );

    header('Location: index.php?page=penyewa');
    exit();
}

?>

<h3 class="mb-4">
    Tambah Penyewa
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama Penyewa
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    No HP
                </label>

                <input
                    type="text"
                    name="no_hp"
                    class="form-control"
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Alamat
                </label>

                <textarea
                    name="alamat"
                    class="form-control"
                    rows="3"
                ></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    class="form-control"
                    rows="3"
                ></textarea>

            </div>

            <button
                type="submit"
                name="submit"
                class="btn btn-dark"
            >
                Simpan
            </button>

            <a
                href="index.php?page=penyewa"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </form>

    </div>

</div>
