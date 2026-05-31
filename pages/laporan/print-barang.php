<?php

include '../../config/koneksi.php';

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

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>

        Print Barang Paling Disewa

    </title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            padding: 40px;
            color: #0f172a;
        }

        .print-container {
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .print-header {
            padding: 35px 40px;
            background: linear-gradient(135deg,
                    #0f172a,
                    #1e293b);
            color: white;
        }

        .brand {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-left h1 {
            font-size: 34px;
            margin-bottom: 6px;
        }

        .brand-left p {
            font-size: 15px;
            opacity: .8;
        }

        .report-title {
            text-align: right;
        }

        .report-title h2 {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .report-title span {
            font-size: 14px;
            opacity: .8;
        }

        .table-wrapper {
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #16a34a;
            color: white;
        }

        table th {
            padding: 16px;
            font-size: 14px;
            text-align: left;
        }

        table td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .number-box {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .sewa-badge {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 12px;
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
            font-weight: 700;
        }

        .ranking {
            font-weight: 700;
        }

        .gold {
            color: #d97706;
        }

        .silver {
            color: #64748b;
        }

        .bronze {
            color: #92400e;
        }

        .footer {
            padding: 25px 40px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #64748b;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .print-container {
                box-shadow: none;
                border-radius: 0;
            }

        }
    </style>

</head>

<body>

    <div class="print-container">

        <!-- HEADER -->

        <div class="print-header">

            <div class="brand">

                <div class="brand-left">

                    <h1>

                        MountRent

                    </h1>

                    <p>

                        Rental Perlengkapan Outdoor & Pendakian

                    </p>

                </div>

                <div class="report-title">

                    <h2>

                        Barang Paling Disewa

                    </h2>

                    <span>

                        Dicetak:
                        <?= date('d F Y') ?>

                    </span>

                </div>

            </div>

        </div>

        <!-- TABLE -->

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th width="10%">
                            No
                        </th>

                        <th>
                            Nama Barang
                        </th>

                        <th width="25%">
                            Total Disewa
                        </th>

                        <th width="20%">
                            Ranking
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while ($data = mysqli_fetch_assoc($query)) :

                        if ($no == 1) {

                            $ranking = '
                                <span class="ranking gold">
                                    #1 Terlaris
                                </span>
                            ';
                        } elseif ($no == 2) {

                            $ranking = '
                                <span class="ranking silver">
                                    #2 Favorit
                                </span>
                            ';
                        } elseif ($no == 3) {

                            $ranking = '
                                <span class="ranking bronze">
                                    #3 Populer
                                </span>
                            ';
                        } else {

                            $ranking = '
                                <span class="ranking">
                                    Top Rental
                                </span>
                            ';
                        }

                    ?>

                    <tr>

                        <td>

                            <div class="number-box">

                                <?= $no++ ?>

                            </div>

                        </td>

                        <td>

                            <?= $data['nama_barang'] ?>

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

        <!-- FOOTER -->

        <div class="footer">

            <div>

                Sistem Rental Perlengkapan Outdoor

            </div>

            <div>

                MountRent © <?= date('Y') ?>

            </div>

        </div>

    </div>

    <script>
        window.print();
    </script>

</body>

</html>
