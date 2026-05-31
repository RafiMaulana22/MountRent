<?php

include 'config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");

echo "
        <script>
            window.location =
                'index.php?page=kategori';
        </script>
    ";

exit();
