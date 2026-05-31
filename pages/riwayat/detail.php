<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "
    SELECT
        transaksi.*,
        penyewa.nama

    FROM transaksi

    JOIN penyewa
    ON transaksi.penyewa_id = penyewa.id

    WHERE transaksi.id = '$id'
",
);

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query(
    $conn,
    "
    SELECT

        detail_transaksi.*,

        barang.nama_barang,

        paket_rental.nama_paket

    FROM detail_transaksi

    LEFT JOIN barang
    ON detail_transaksi.barang_id = barang.id

    LEFT JOIN paket_rental
    ON detail_transaksi.paket_id = paket_rental.id

    WHERE transaksi_id = '$id'
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Detail Riwayat Transaksi

        </h2>

        <p class="page-subtitle">

            Informasi lengkap riwayat transaksi penyewaan

        </p>

    </div>

    <a href="index.php?page=riwayat" class="btn btn-light btn-back">
        <i class="bi bi-arrow-left me-2"></i>

        Kembali
    </a>

</div>

<div class="row g-4">

    <!-- LEFT -->

    <div class="col-lg-4">

        <!-- SUMMARY CARD -->

        <div class="transaction-detail-card">

            <div class="detail-icon">

                <i class="bi bi-clock-history"></i>

            </div>

            <h4 class="detail-title">

                <?= $data['kode_transaksi'] ?>

            </h4>

            <p class="detail-subtitle">

                Detail riwayat transaksi penyewaan perlengkapan outdoor MountRent

            </p>

            <div class="detail-info-list">

                <!-- PENYEWA -->

                <div class="detail-info-item">

                    <div class="info-icon">

                        <i class="bi bi-person-fill"></i>

                    </div>

                    <div>

                        <small>
                            Penyewa
                        </small>

                        <div class="info-value">

                            <?= $data['nama'] ?>

                        </div>

                    </div>

                </div>

                <!-- TANGGAL SEWA -->

                <div class="detail-info-item">

                    <div class="info-icon">

                        <i class="bi bi-calendar-check-fill"></i>

                    </div>

                    <div>

                        <small>
                            Tanggal Sewa
                        </small>

                        <div class="info-value">

                            <?= date('d M Y', strtotime($data['tanggal_sewa'])) ?>

                        </div>

                    </div>

                </div>

                <!-- TANGGAL KEMBALI -->

                <div class="detail-info-item">

                    <div class="info-icon">

                        <i class="bi bi-calendar2-week-fill"></i>

                    </div>

                    <div>

                        <small>
                            Tanggal Kembali
                        </small>

                        <div class="info-value">

                            <?= date('d M Y', strtotime($data['tanggal_kembali'])) ?>

                        </div>

                    </div>

                </div>

                <!-- TOTAL -->

                <div class="detail-total-box">

                    <small>
                        Total Transaksi
                    </small>

                    <h3>

                        Rp <?= number_format($data['total']) ?>

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- RIGHT -->

    <div class="col-lg-8">

        <div class="card modern-card border-0">

            <div class="card-body p-4">

                <div class="section-title mb-4">

                    <i class="bi bi-box-seam-fill"></i>

                    Detail Item Rental

                </div>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th width="5%">
                                    No
                                </th>

                                <th>
                                    Item
                                </th>

                                <th>
                                    Harga
                                </th>

                                <th>
                                    Jumlah
                                </th>

                                <th>
                                    Lama Hari
                                </th>

                                <th>
                                    Subtotal
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $no = 1;

                            while($d = mysqli_fetch_assoc($detail)) :
                            ?>

                            <tr>

                                <!-- NO -->

                                <td>

                                    <span class="table-number">

                                        <?= $no++ ?>

                                    </span>

                                </td>

                                <!-- ITEM -->

                                <td>

                                    <div class="item-box">

                                        <div class="item-icon">

                                            <?php if($d['nama_barang']) : ?>

                                            <i class="bi bi-backpack-fill"></i>

                                            <?php else : ?>

                                            <i class="bi bi-box2-heart-fill"></i>

                                            <?php endif; ?>

                                        </div>

                                        <div>

                                            <div class="fw-bold text-dark">

                                                <?= $d['nama_barang'] ?: $d['nama_paket'] ?>

                                            </div>

                                            <small class="text-muted">

                                                <?= $d['nama_barang'] ? 'Barang Rental' : 'Paket Rental' ?>

                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <!-- HARGA -->

                                <td>

                                    <div class="price-tag">

                                        Rp <?= number_format($d['harga']) ?>

                                    </div>

                                </td>

                                <!-- JUMLAH -->

                                <td>

                                    <span class="qty-badge">

                                        <?= $d['jumlah'] ?>x

                                    </span>

                                </td>

                                <!-- HARI -->

                                <td>

                                    <span class="day-badge">

                                        <?= $d['lama_hari'] ?> Hari

                                    </span>

                                </td>

                                <!-- SUBTOTAL -->

                                <td>

                                    <div class="subtotal-box">

                                        Rp <?= number_format($d['subtotal']) ?>

                                    </div>

                                </td>

                            </tr>

                            <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
