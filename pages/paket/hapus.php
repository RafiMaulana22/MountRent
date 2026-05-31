<?php

include 'config/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM paket_rental WHERE id = '$id'");

$data = mysqli_fetch_assoc($query);

if ($data['foto'] != '') {
    unlink('uploads/paket/' . $data['foto']);
}

mysqli_query($conn, "DELETE FROM paket_detail WHERE paket_id = '$id'");

mysqli_query($conn, "DELETE FROM paket_rental WHERE id = '$id'");

header('Location: index.php?page=paket');
exit();
