<?php

include 'config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM penyewa WHERE id = '$id'");

header('Location: index.php?page=penyewa');
exit();
