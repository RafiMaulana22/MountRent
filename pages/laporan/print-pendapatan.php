<?php

include '../../config/koneksi.php';

$where = '';

$totalPendapatan = 0;

if (isset($_GET['tanggal_awal']) && isset($_GET['tanggal_akhir'])) {
    $tanggal_awal = $_GET['tanggal_awal'];
    $tanggal_akhir = $_GET['tanggal_akhir'];

    if ($tanggal_awal != '' && $tanggal_akhir != '') {
        $where = "
            WHERE tanggal_sewa
            BETWEEN '$tanggal_awal'
            AND '$tanggal_akhir'
        ";
    }
}

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM transaksi
    $where
    ORDER BY id DESC
",
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Print Laporan Pendapatan
    </title>

    <!-- GOOGLE FONT -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {

            margin: 0;
            padding: 0;

            box-sizing: border-box;

            font-family: 'Poppins', sans-serif;
        }

        body {

            padding: 40px;

            background: white;

            color: #0f172a;
        }

        .print-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

            padding-bottom: 24px;

            border-bottom: 3px solid #16a34a;

            margin-bottom: 35px;
        }

        .company-logo {

            display: flex;

            align-items: center;

            gap: 18px;
        }

        .logo-box {

            width: 70px;
            height: 70px;

            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    #16a34a,
                    #15803d);

            display: flex;

            align-items: center;
            justify-content: center;

            color: white;

            font-size: 32px;

            font-weight: 700;
        }

        .company-title {

            font-size: 28px;

            font-weight: 700;

            color: #0f172a;
        }

        .company-subtitle {

            color: #64748b;

            font-size: 15px;
        }

        .report-title {

            text-align: right;
        }

        .report-title h2 {

            font-size: 26px;

            margin-bottom: 8px;
        }

        .report-date {

            color: #64748b;

            font-size: 14px;
        }

        .filter-info {

            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 18px;

            padding: 18px 22px;

            margin-bottom: 30px;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .summary-card {

            background:
                linear-gradient(135deg,
                    #16a34a,
                    #15803d);

            border-radius: 24px;

            padding: 28px;

            color: white;

            margin-bottom: 30px;
        }

        .summary-label {

            font-size: 15px;

            opacity: 0.8;

            margin-bottom: 10px;
        }

        .summary-total {

            font-size: 34px;

            font-weight: 700;
        }

        table {

            width: 100%;

            border-collapse: collapse;
        }

        table thead th {

            background: #0f172a;

            color: white;

            padding: 16px;

            text-align: left;

            font-size: 14px;

            font-weight: 600;
        }

        table tbody td {

            padding: 15px 16px;

            border-bottom: 1px solid #e2e8f0;

            font-size: 14px;
        }

        table tbody tr:nth-child(even) {

            background: #f8fafc;
        }

        .price {

            font-weight: 700;

            color: #16a34a;
        }

        table tfoot th {

            padding: 18px 16px;

            background: #f1f5f9;

            font-size: 15px;
        }

        .footer-print {

            margin-top: 60px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            color: #64748b;

            font-size: 13px;
        }

        @media print {

            body {

                padding: 20px;
            }

            .footer-print {

                position: fixed;

                bottom: 0;

                left: 0;
                right: 0;
            }
        }
    </style>

</head>

<body>

    <!-- HEADER -->

    <div class="print-header">

        <div class="company-logo">

            <div class="logo-box">

                M

            </div>

            <div>

                <div class="company-title">

                    MountRent

                </div>

                <div class="company-subtitle">

                    Rental Perlengkapan Outdoor & Pendakian

                </div>

            </div>

        </div>

        <div class="report-title">

            <h2>

                Laporan Pendapatan

            </h2>

            <div class="report-date">

                Dicetak:
                <?= date('d F Y') ?>

            </div>

        </div>

    </div>

    <!-- FILTER INFO -->

    <div class="filter-info">

        <div>

            <strong>
                Periode Laporan:
            </strong>

            <?php if (
                isset($_GET['tanggal_awal']) &&
                $_GET['tanggal_awal'] != ''
            ) : ?>

            <?= date('d M Y', strtotime($_GET['tanggal_awal'])) ?>

            -

            <?= date('d M Y', strtotime($_GET['tanggal_akhir'])) ?>

            <?php else : ?>

            Semua Data Transaksi

            <?php endif; ?>

        </div>

        <div>

            <strong>
                Total Data:
            </strong>

            <?= mysqli_num_rows($query) ?>

            Transaksi

        </div>

    </div>

    <!-- SUMMARY -->

    <?php

    mysqli_data_seek($query, 0);

    while ($item = mysqli_fetch_assoc($query)) {
        $totalPendapatan += $item['total'];
    }

    mysqli_data_seek($query, 0);

    ?>

    <div class="summary-card">

        <div class="summary-label">

            Total Pendapatan Rental

        </div>

        <div class="summary-total">

            Rp <?= number_format($totalPendapatan) ?>

        </div>

    </div>

    <!-- TABLE -->

    <table>

        <thead>

            <tr>

                <th width="8%">
                    No
                </th>

                <th>
                    Kode Transaksi
                </th>

                <th>
                    Tanggal Sewa
                </th>

                <th>
                    Total
                </th>

            </tr>

        </thead>

        <tbody>

            <?php
            $no = 1;

            while ($data = mysqli_fetch_assoc($query)) :
            ?>

            <tr>

                <td>

                    <?= $no++ ?>

                </td>

                <td>

                    <?= $data['kode_transaksi'] ?>

                </td>

                <td>

                    <?= date('d F Y', strtotime($data['tanggal_sewa'])) ?>

                </td>

                <td class="price">

                    Rp
                    <?= number_format($data['total']) ?>

                </td>

            </tr>

            <?php endwhile; ?>

        </tbody>

        <tfoot>

            <tr>

                <th colspan="3">

                    Total Pendapatan

                </th>

                <th>

                    Rp <?= number_format($totalPendapatan) ?>

                </th>

            </tr>

        </tfoot>

    </table>

    <!-- FOOTER -->

    <div class="footer-print">

        <div>

            © <?= date('Y') ?> MountRent

        </div>

        <div>

            Sistem Rental Perlengkapan Outdoor

        </div>

    </div>

    <script>
        window.print();
    </script>

</body>

</html>
