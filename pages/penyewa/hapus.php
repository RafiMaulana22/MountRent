<?php

include 'config/koneksi.php';

$id = $_GET['id'];

// CEK TRANSAKSI

$cek = mysqli_query(
    $conn,
    "
    SELECT *
    FROM transaksi
    WHERE penyewa_id = '$id'
",
);

// JIKA MASIH ADA TRANSAKSI

if (mysqli_num_rows($cek) > 0) {
    echo "
        <script>

            Swal.fire({

                icon: 'warning',

                title: 'Tidak Bisa Dihapus',

                text:
                    'Penyewa masih memiliki transaksi.',

                confirmButtonColor: '#16a34a',

                confirmButtonText: 'OK',

                borderRadius: 20

            }).then(() => {

                window.location.href =
                    'index.php?page=penyewa';

            });

        </script>
    ";

    exit();
}

// HAPUS DATA

mysqli_query(
    $conn,
    "
    DELETE FROM penyewa
    WHERE id = '$id'
",
);

// ALERT BERHASIL

echo "
    <script>

        Swal.fire({

            icon: 'success',

            title: 'Berhasil',

            text:
                'Data penyewa berhasil dihapus.',

            confirmButtonColor: '#16a34a',

            confirmButtonText: 'OK',

            borderRadius: 20

        }).then(() => {

            window.location.href =
                'index.php?page=penyewa';

        });

    </script>
";

exit();

?>
