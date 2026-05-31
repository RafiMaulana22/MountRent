<?php

include 'config/koneksi.php';

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

    <title>
        Print Laporan Pendapatan
    </title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 10px;
            font-size: 14px;
        }

        table th {
            background: #f2f2f2;
        }
    </style>

</head>

<body>

    <h2>
        Laporan Pendapatan Rental
    </h2>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal Sewa</th>
                <th>Total</th>
            </tr>

        </thead>

        <tbody>

            <?php
            $no = 1;

            while($data = mysqli_fetch_assoc($query)) :

                $totalPendapatan += $data['total'];
            ?>

            <tr>

                <td><?= $no++ ?></td>

                <td><?= $data['kode_transaksi'] ?></td>

                <td><?= $data['tanggal_sewa'] ?></td>

                <td>
                    Rp <?= number_format($data['total']) ?>
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

    <script>
        window.print();
    </script>

</body>

</html>
