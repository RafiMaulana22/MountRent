<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");

$data = mysqli_fetch_assoc($query);

if ($data['foto'] != '') {
    unlink('uploads/barang/' . $data['foto']);
}

mysqli_query($conn, "DELETE FROM barang WHERE id = '$id'");

header('Location: index.php?page=barang');
exit();
