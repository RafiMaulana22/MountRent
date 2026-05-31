<?php

include 'config/koneksi.php';

$penyewa = mysqli_query($conn, 'SELECT * FROM penyewa ORDER BY nama ASC');

$barang = mysqli_query($conn, 'SELECT * FROM barang ORDER BY nama_barang ASC');

$paket = mysqli_query($conn, 'SELECT * FROM paket_rental ORDER BY nama_paket ASC');

$queryKode = mysqli_query($conn, 'SELECT MAX(kode_transaksi) as kodeTerbesar FROM transaksi');

$dataKode = mysqli_fetch_assoc($queryKode);

$kode = $dataKode['kodeTerbesar'];

if ($kode) {
    $urutan = (int) substr($kode, 3, 3);

    $urutan++;
} else {
    $urutan = 1;
}

$kode_transaksi = 'TRX' . sprintf('%03s', $urutan);

if (isset($_POST['submit'])) {
    $nama_penyewa = htmlspecialchars($_POST['nama_penyewa']);

    $queryPenyewa = mysqli_query($conn, "SELECT * FROM penyewa WHERE nama = '$nama_penyewa'",);

    $dataPenyewa = mysqli_fetch_assoc($queryPenyewa);

    if ($dataPenyewa) {
        // jika sudah ada
        $penyewa_id = $dataPenyewa['id'];
    } else {
        // tambah penyewa baru

        mysqli_query($conn, "INSERT INTO penyewa (nama) VALUES ('$nama_penyewa')",);

        $penyewa_id = mysqli_insert_id($conn);
    }

    $tanggal_sewa = $_POST['tanggal_sewa'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $selisih = (strtotime($tanggal_kembali) - strtotime($tanggal_sewa)) / (60 * 60 * 24);

    $lama_hari = $selisih + 1;

    $total = 0;

    mysqli_query(
        $conn,
        "
        INSERT INTO transaksi (
            kode_transaksi,
            penyewa_id,
            tanggal_sewa,
            tanggal_kembali,
            total
        ) VALUES (
            '$kode_transaksi',
            '$penyewa_id',
            '$tanggal_sewa',
            '$tanggal_kembali',
            '0'
        )
    ",
    );

    $transaksi_id = mysqli_insert_id($conn);

    // =====================
    // BARANG
    // =====================

    if (isset($_POST['barang'])) {
        foreach ($_POST['barang'] as $barang_id => $value) {
            $jumlah = $_POST['jumlah_barang'][$barang_id];

            $queryBarang = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$barang_id'");

            $dataBarang = mysqli_fetch_assoc($queryBarang);

            $harga_awal = $dataBarang['harga_sewa'];

            $harga_tambah = $dataBarang['harga_tambah_hari'];

            $subtotal = ($harga_awal + $harga_tambah * ($lama_hari - 1)) * $jumlah;

            $total += $subtotal;

            mysqli_query(
                $conn,
                "
                INSERT INTO detail_transaksi (
                    transaksi_id,
                    barang_id,
                    harga,
                    jumlah,
                    lama_hari,
                    subtotal
                ) VALUES (
                    '$transaksi_id',
                    '$barang_id',
                    '$harga_awal',
                    '$jumlah',
                    '$lama_hari',
                    '$subtotal'
                )
            ",
            );
        }
    }

    // =====================
    // PAKET
    // =====================

    if (isset($_POST['paket'])) {
        foreach ($_POST['paket'] as $paket_id => $value) {
            $jumlah = $_POST['jumlah_paket'][$paket_id];

            $queryPaket = mysqli_query($conn, "SELECT * FROM paket_rental WHERE id = '$paket_id'");

            $dataPaket = mysqli_fetch_assoc($queryPaket);

            $subtotal = $dataPaket['harga_paket'] * $jumlah;

            $total += $subtotal;

            mysqli_query(
                $conn,
                "
                INSERT INTO detail_transaksi (
                    transaksi_id,
                    paket_id,
                    harga,
                    jumlah,
                    lama_hari,
                    subtotal
                ) VALUES (
                    '$transaksi_id',
                    '$paket_id',
                    '" .
                    $dataPaket['harga_paket'] .
                    "',
                    '$jumlah',
                    '$lama_hari',
                    '$subtotal'
                )
            ",
            );
        }
    }

    mysqli_query(
        $conn,
        "
        UPDATE transaksi
        SET total = '$total'
        WHERE id = '$transaksi_id'
    ",
    );

    header('Location: index.php?page=transaksi');
    exit();
}

?>

<h3 class="mb-4">
    Tambah Transaksi
</h3>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Kode Transaksi
                    </label>

                    <input type="text" class="form-control" value="<?= $kode_transaksi ?>" readonly>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Nama Penyewa
                    </label>

                    <input type="text" name="nama_penyewa" class="form-control" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Tanggal Sewa
                    </label>

                    <input type="date" name="tanggal_sewa" class="form-control" required>

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Tanggal Kembali
                    </label>

                    <input type="date" name="tanggal_kembali" class="form-control" required>

                </div>

            </div>

            <hr>

            <h5 class="mb-3">
                Pilih Barang
            </h5>

            <?php while($b = mysqli_fetch_assoc($barang)) : ?>

            <div class="border rounded p-3 mb-2">

                <div class="form-check mb-2">

                    <input type="checkbox" name="barang[<?= $b['id'] ?>]" value="<?= $b['id'] ?>"
                        class="form-check-input">

                    <label class="form-check-label">

                        <?= $b['nama_barang'] ?>

                        -
                        Rp <?= number_format($b['harga_sewa']) ?>

                    </label>

                </div>

                <input type="number" name="jumlah_barang[<?= $b['id'] ?>]" class="form-control" min="1"
                    value="1">

            </div>

            <?php endwhile; ?>

            <hr>

            <h5 class="mb-3">
                Pilih Paket
            </h5>

            <?php while($pk = mysqli_fetch_assoc($paket)) : ?>

            <div class="border rounded p-3 mb-2">

                <div class="form-check mb-2">

                    <input type="checkbox" name="paket[<?= $pk['id'] ?>]" value="<?= $pk['id'] ?>"
                        class="form-check-input">

                    <label class="form-check-label">

                        <?= $pk['nama_paket'] ?>

                        -
                        Rp <?= number_format($pk['harga_paket']) ?>

                    </label>

                </div>

                <input type="number" name="jumlah_paket[<?= $pk['id'] ?>]" class="form-control" min="1"
                    value="1">

            </div>

            <?php endwhile; ?>

            <button type="submit" name="submit" class="btn btn-dark mt-3">
                Simpan Transaksi
            </button>

        </form>

    </div>

</div>
