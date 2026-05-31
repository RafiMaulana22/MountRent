<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM paket_rental
    ORDER BY id DESC
"
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Paket Rental

        </h2>

        <p class="page-subtitle">

            Kelola paket perlengkapan rental outdoor

        </p>

    </div>

    <a
        href="index.php?page=paket-tambah"
        class="btn btn-success btn-modern"
    >
        <i class="bi bi-plus-circle me-2"></i>

        Tambah Paket
    </a>

</div>

<!-- CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table
                class="table align-middle"
                id="tablePaket"
            >

                <thead>

                    <tr>

                        <th width="6%">
                            No
                        </th>

                        <th width="12%">
                            Foto
                        </th>

                        <th>
                            Nama Paket
                        </th>

                        <th width="28%">
                            Isi Paket
                        </th>

                        <th width="15%">
                            Harga
                        </th>

                        <th width="14%">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while($data = mysqli_fetch_assoc($query)) :
                    ?>

                    <tr>

                        <!-- NO -->

                        <td>

                            <span class="table-number">

                                <?= $no++ ?>

                            </span>

                        </td>

                        <!-- FOTO -->

                        <td>

                            <img
                                src="uploads/paket/<?= $data['foto'] ?>"
                                class="table-image"
                            >

                        </td>

                        <!-- NAMA -->

                        <td>

                            <div class="d-flex flex-column">

                                <span class="fw-semibold table-title">

                                    <?= $data['nama_paket'] ?>

                                </span>

                                <small class="table-subtitle">

                                    Paket Rental Outdoor

                                </small>

                            </div>

                        </td>

                        <!-- ISI PAKET -->

                        <td>

                            <div class="package-items">

                                <?php

                                $detail = mysqli_query(
                                    $conn,
                                    "
                                    SELECT
                                        barang.nama_barang,
                                        paket_detail.jumlah

                                    FROM paket_detail

                                    JOIN barang
                                    ON paket_detail.barang_id = barang.id

                                    WHERE paket_detail.paket_id = '" . $data['id'] . "'
                                "
                                );

                                while ($d = mysqli_fetch_assoc($detail)) :
                                ?>

                                <div class="package-badge">

                                    <span>

                                        <?= $d['nama_barang'] ?>

                                    </span>

                                    <strong>

                                        x<?= $d['jumlah'] ?>

                                    </strong>

                                </div>

                                <?php endwhile; ?>

                            </div>

                        </td>

                        <!-- HARGA -->

                        <td>

                            <div class="price-box">

                                Rp <?= number_format($data['harga_paket']) ?>

                            </div>

                        </td>

                        <!-- AKSI -->

                        <td>

                            <div class="d-flex gap-2">

                                <!-- EDIT -->

                                <a
                                    href="index.php?page=paket-edit&id=<?= $data['id'] ?>"
                                    class="btn btn-warning btn-action"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- HAPUS -->

                                <button
                                    type="button"
                                    class="btn btn-danger btn-action btn-delete"

                                    data-href="
                                        index.php?page=paket-hapus&id=<?= $data['id'] ?>
                                    "
                                >
                                    <i class="bi bi-trash-fill"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- DATATABLE -->

<script>

    $(document).ready(function() {

        $('#tablePaket').DataTable({

            responsive: true,

            pageLength: 10,

            autoWidth: false,

            language: {

                search: "_INPUT_",

                searchPlaceholder:
                    "Cari paket rental...",

                lengthMenu:
                    "Tampilkan _MENU_ data",

                info:
                    "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                paginate: {

                    previous: "‹",

                    next: "›"
                }
            }

        });

    });

</script>

<!-- DELETE -->

<script>

    $(document).ready(function() {

        $(document).on(
            'click',
            '.btn-delete',
            function() {

                let href =
                    $(this).data('href');

                Swal.fire({

                    title: 'Hapus Paket?',

                    text:
                        'Data paket rental akan dihapus permanen.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#dc2626',

                    cancelButtonColor: '#64748b',

                    confirmButtonText: 'Ya, Hapus',

                    cancelButtonText: 'Batal',

                    borderRadius: 20

                }).then((result) => {

                    if (result.isConfirmed) {

                        window.location.href =
                            href;
                    }

                });

            }
        );

    });

</script>
