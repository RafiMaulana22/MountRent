<?php

session_start();

include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

$data = mysqli_fetch_assoc($query);

if ($data) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;

        $_SESSION['id_user'] = $data['id'];

        $_SESSION['nama_lengkap'] = $data['nama_lengkap'];

        header("Location: ../index.php?page=dashboard");
        exit();
    }
}

header('Location: login.php?pesan=gagal');
exit();
