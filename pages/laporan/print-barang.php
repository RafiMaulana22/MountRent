<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT
        nama_barang,
        SUM(total_disewa) as total_sewa

    FROM (

        -- barang langsung
        SELECT
            barang.nama_barang,
            detail_transaksi.jumlah as total_disewa

        FROM detail_transaksi

        JOIN barang
        ON detail_transaksi.barang_id = barang.id

        WHERE detail_transaksi.barang_id IS NOT NULL

        UNION ALL

        -- barang dari paket
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

    <title>
        Print Barang Paling Disewa
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
        Laporan Barang Paling Disewa
    </h2>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Total Disewa</th>
            </tr>

        </thead>

        <tbody>

            <?php
            $no = 1;

            while($data = mysqli_fetch_assoc($query)) :
            ?>

            <tr>

                <td><?= $no++ ?></td>

                <td><?= $data['nama_barang'] ?></td>

                <td><?= $data['total_sewa'] ?></td>

            </tr>

            <?php endwhile; ?>

        </tbody>

    </table>

    <script>
        window.print();
    </script>

</body>

</html>
