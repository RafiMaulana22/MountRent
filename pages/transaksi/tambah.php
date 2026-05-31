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

    $queryPenyewa = mysqli_query($conn, "SELECT * FROM penyewa WHERE nama = '$nama_penyewa'");

    $dataPenyewa = mysqli_fetch_assoc($queryPenyewa);

    if ($dataPenyewa) {
        // jika sudah ada
        $penyewa_id = $dataPenyewa['id'];
    } else {
        // tambah penyewa baru

        mysqli_query($conn, "INSERT INTO penyewa (nama) VALUES ('$nama_penyewa')");

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

    echo "
        <script>
            window.location.href =
                'index.php?page=transaksi';
        </script>
    ";

    exit();
}

?>


<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Tambah Transaksi

        </h2>

        <p class="page-subtitle">

            Tambahkan transaksi penyewaan perlengkapan outdoor

        </p>

    </div>

    <a href="index.php?page=transaksi" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<!-- FORM -->

<form method="POST">

    <div class="row g-4">

        <!-- LEFT -->

        <div class="col-lg-8">

            <!-- INFORMASI TRANSAKSI -->

            <div class="card modern-card border-0 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="section-title mb-4">

                        <i class="bi bi-receipt-cutoff"></i>

                        Informasi Transaksi

                    </div>

                    <div class="row">

                        <!-- KODE -->

                        <div class="col-md-6 mb-4">

                            <label class="form-label modern-label">

                                Kode Transaksi

                            </label>

                            <div class="input-group modern-input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-upc-scan"></i>

                                </span>

                                <input type="text" class="form-control modern-input" value="<?= $kode_transaksi ?>"
                                    readonly>

                            </div>

                        </div>

                        <!-- PENYEWA -->

                        <div class="col-md-6 mb-4">

                            <label class="form-label modern-label">

                                Nama Penyewa

                            </label>

                            <div class="input-group modern-input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-person-fill"></i>

                                </span>

                                <input type="text" name="nama_penyewa" class="form-control modern-input"
                                    placeholder="Masukkan nama penyewa" required>

                            </div>

                        </div>

                        <!-- TANGGAL SEWA -->

                        <div class="col-md-6 mb-4">

                            <label class="form-label modern-label">

                                Tanggal Sewa

                            </label>

                            <div class="input-group modern-input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-calendar-check-fill"></i>

                                </span>

                                <input type="date" name="tanggal_sewa" class="form-control modern-input" required>

                            </div>

                        </div>

                        <!-- TANGGAL KEMBALI -->

                        <div class="col-md-6 mb-4">

                            <label class="form-label modern-label">

                                Tanggal Kembali

                            </label>

                            <div class="input-group modern-input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-calendar2-week-fill"></i>

                                </span>

                                <input type="date" name="tanggal_kembali" class="form-control modern-input" required>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- BARANG -->

            <div class="card modern-card border-0 mb-4">

                <div class="card-body p-4 p-lg-5">

                    <div class="section-title mb-4">

                        <i class="bi bi-backpack-fill"></i>

                        Pilih Barang Rental

                    </div>

                    <div class="package-selection">

                        <?php while($b = mysqli_fetch_assoc($barang)) : ?>

                        <div class="package-item-card">

                            <div class="d-flex justify-content-between align-items-center">

                                <!-- CHECK -->

                                <div class="form-check d-flex align-items-center gap-3">

                                    <input type="checkbox" name="barang[<?= $b['id'] ?>]" value="<?= $b['id'] ?>"
                                        class="form-check-input package-checkbox" id="barang<?= $b['id'] ?>">

                                    <label class="form-check-label package-label" for="barang<?= $b['id'] ?>">

                                        <div class="package-icon">

                                            <i class="bi bi-backpack-fill"></i>

                                        </div>

                                        <div>

                                            <div class="package-name">

                                                <?= $b['nama_barang'] ?>

                                            </div>

                                            <small class="package-category">

                                                Rp <?= number_format($b['harga_sewa']) ?>

                                            </small>

                                        </div>

                                    </label>

                                </div>

                                <!-- JUMLAH -->

                                <div class="package-qty">

                                    <label class="qty-label">

                                        Jumlah

                                    </label>

                                    <input type="number" name="jumlah_barang[<?= $b['id'] ?>]"
                                        class="form-control qty-input" min="1" value="1">

                                </div>

                            </div>

                        </div>

                        <?php endwhile; ?>

                    </div>

                </div>

            </div>

            <!-- PAKET -->

            <div class="card modern-card border-0">

                <div class="card-body p-4 p-lg-5">

                    <div class="section-title mb-4">

                        <i class="bi bi-box2-heart-fill"></i>

                        Pilih Paket Rental

                    </div>

                    <div class="package-selection">

                        <?php while($pk = mysqli_fetch_assoc($paket)) : ?>

                        <div class="package-item-card">

                            <div class="d-flex justify-content-between align-items-center">

                                <!-- CHECK -->

                                <div class="form-check d-flex align-items-center gap-3">

                                    <input type="checkbox" name="paket[<?= $pk['id'] ?>]" value="<?= $pk['id'] ?>"
                                        class="form-check-input package-checkbox" id="paket<?= $pk['id'] ?>">

                                    <label class="form-check-label package-label" for="paket<?= $pk['id'] ?>">

                                        <div class="package-icon">

                                            <i class="bi bi-box-fill"></i>

                                        </div>

                                        <div>

                                            <div class="package-name">

                                                <?= $pk['nama_paket'] ?>

                                            </div>

                                            <small class="package-category">

                                                Rp <?= number_format($pk['harga_paket']) ?>

                                            </small>

                                        </div>

                                    </label>

                                </div>

                                <!-- JUMLAH -->

                                <div class="package-qty">

                                    <label class="qty-label">

                                        Jumlah

                                    </label>

                                    <input type="number" name="jumlah_paket[<?= $pk['id'] ?>]"
                                        class="form-control qty-input" min="1" value="1">

                                </div>

                            </div>

                        </div>

                        <?php endwhile; ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="col-lg-4">

            <div class="transaction-summary-card">

                <div class="summary-icon">

                    <i class="bi bi-mountains-fill"></i>

                </div>

                <h4 class="summary-title">

                    Transaksi Rental

                </h4>

                <p class="summary-subtitle">

                    Pastikan data penyewaan sudah benar sebelum menyimpan transaksi rental.

                </p>

                <div class="summary-info">

                    <div class="summary-item">

                        <i class="bi bi-shield-check"></i>

                        Data Aman
                    </div>

                    <div class="summary-item">

                        <i class="bi bi-lightning-charge-fill"></i>

                        Proses Cepat
                    </div>

                    <div class="summary-item">

                        <i class="bi bi-database-check"></i>

                        Tersimpan Otomatis
                    </div>

                </div>

                <button type="submit" name="submit" class="btn btn-success btn-modern-submit w-100 mt-4">
                    <i class="bi bi-check-circle-fill me-2"></i>

                    Simpan Transaksi
                </button>

            </div>

        </div>

    </div>

</form>
