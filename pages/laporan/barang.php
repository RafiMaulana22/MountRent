<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT
        nama_barang,
        SUM(total_disewa) as total_sewa

    FROM (

        -- BARANG LANGSUNG

        SELECT
            barang.nama_barang,
            detail_transaksi.jumlah as total_disewa

        FROM detail_transaksi

        JOIN barang
        ON detail_transaksi.barang_id = barang.id

        WHERE detail_transaksi.barang_id IS NOT NULL

        UNION ALL

        -- BARANG DARI PAKET

        SELECT
            barang.nama_barang,

            (
                detail_transaksi.jumlah *
                paket_detail.jumlah
            ) as total_disewa

        FROM detail_transaksi

        JOIN paket_rental
        ON detail_transaksi.paket_id = paket_rental.id

        JOIN paket_detail
        ON paket_rental.id = paket_detail.paket_id

        JOIN barang
        ON paket_detail.barang_id = barang.id

        WHERE detail_transaksi.paket_id IS NOT NULL

    ) as hasil

    GROUP BY nama_barang

    ORDER BY total_sewa DESC
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Barang Paling Disewa

        </h2>

        <p class="page-subtitle">

            Statistik perlengkapan outdoor yang paling sering disewa

        </p>

    </div>

    <div class="d-flex gap-2">

        <a href="index.php?page=laporan" class="btn btn-light btn-back">

            <i class="bi bi-arrow-left me-2"></i>

            Kembali

        </a>

        <a href="pages/laporan/print-barang.php" target="_blank" class="btn btn-success btn-modern">

            <i class="bi bi-printer-fill me-2"></i>

            Print Laporan

        </a>

    </div>

</div>

<!-- CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tableBarangTerlaris">

                <thead>

                    <tr>

                        <th width="8%">
                            No
                        </th>

                        <th>
                            Nama Barang
                        </th>

                        <th width="20%">
                            Total Disewa
                        </th>

                        <th width="18%">
                            Ranking
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while ($data = mysqli_fetch_assoc($query)) :

                        // BADGE RANKING

                        if ($no == 1) {

                            $ranking = '
                                <span class="ranking-badge gold">
                                    <i class="bi bi-trophy-fill"></i>
                                    #1 Terlaris
                                </span>
                            ';
                        } elseif ($no == 2) {

                            $ranking = '
                                <span class="ranking-badge silver">
                                    <i class="bi bi-award-fill"></i>
                                    #2 Favorit
                                </span>
                            ';
                        } elseif ($no == 3) {

                            $ranking = '
                                <span class="ranking-badge bronze">
                                    <i class="bi bi-star-fill"></i>
                                    #3 Populer
                                </span>
                            ';
                        } else {

                            $ranking = '
                                <span class="ranking-badge default">
                                    <i class="bi bi-bar-chart-fill"></i>
                                    Top Rental
                                </span>
                            ';
                        }

                    ?>

                    <tr>

                        <td>

                            <span class="table-number">

                                <?= $no++ ?>

                            </span>

                        </td>

                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="barang-icon">

                                    <i class="bi bi-backpack2-fill"></i>

                                </div>

                                <div>

                                    <div class="fw-semibold">

                                        <?= $data['nama_barang'] ?>

                                    </div>

                                    <small class="text-muted">

                                        Perlengkapan Outdoor

                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>

                            <span class="sewa-badge">

                                <?= number_format($data['total_sewa']) ?>x Disewa

                            </span>

                        </td>

                        <td>

                            <?= $ranking ?>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- DATATABLE -->

<script>
    $(document).ready(function() {

        $('#tableBarangTerlaris').DataTable({

            responsive: true,

            pageLength: 10,

            language: {

                search: "_INPUT_",

                searchPlaceholder: "Cari barang...",

                lengthMenu: "Tampilkan _MENU_ data",

                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                paginate: {

                    previous: "‹",

                    next: "›"

                }

            }

        });

    });
</script>
