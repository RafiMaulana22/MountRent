<?php

include '../includes/auth.php';

?>

<?php include '../includes/header.php'; ?>

<?php include '../includes/navbar.php'; ?>

<div class="wrapper">

    <?php include '../includes/sidebar.php'; ?>

    <div class="content">

        <h3 class="mb-4">
            Dashboard Admin
        </h3>

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h5>
                    Selamat Datang,
                    <?= $_SESSION['nama_lengkap'] ?>
                </h5>

                <p class="mb-0">
                    Website Rekap Penyewaan Peralatan Mendaki
                </p>

            </div>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>
