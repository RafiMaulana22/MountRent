<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT
        barang.*,
        kategori.nama_kategori

    FROM barang

    JOIN kategori
    ON barang.kategori_id = kategori.id

    ORDER BY barang.id DESC
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Data Barang

        </h2>

        <p class="page-subtitle">

            Kelola perlengkapan rental outdoor MountRent

        </p>

    </div>

    <a href="index.php?page=barang-tambah" class="btn btn-success btn-modern">
        <i class="bi bi-plus-circle me-2"></i>

        Tambah Barang
    </a>

</div>

<!-- CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tableBarang">

                <thead>

                    <tr>

                        <th width="5%">
                            No
                        </th>

                        <th width="10%">
                            Foto
                        </th>

                        <th>
                            Barang
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Kapasitas
                        </th>

                        <th>
                            1 Hari
                        </th>

                        <th>
                            + Hari
                        </th>

                        <th width="15%">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php
                    $no = 1;

                    while ($data = mysqli_fetch_assoc($query)) :
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

                            <img src="uploads/barang/<?= $data['foto'] ?>" class="barang-image">

                        </td>

                        <!-- BARANG -->

                        <td>

                            <div class="d-flex flex-column">

                                <span class="fw-bold text-dark">

                                    <?= $data['nama_barang'] ?>

                                </span>

                                <small class="text-muted">

                                    <?= $data['kode_barang'] ?>

                                </small>

                            </div>

                        </td>

                        <!-- KATEGORI -->

                        <td>

                            <span class="badge-kategori">

                                <?= $data['nama_kategori'] ?>

                            </span>

                        </td>

                        <!-- KAPASITAS -->

                        <td>

                            <span class="text-muted">

                                <?= $data['kapasitas'] ?>

                            </span>

                        </td>

                        <!-- HARGA -->

                        <td>

                            <div class="harga-box">

                                Rp <?= number_format($data['harga_sewa']) ?>

                            </div>

                        </td>

                        <!-- TAMBAH HARI -->

                        <td>

                            <div class="harga-tambah">

                                Rp <?= number_format($data['harga_tambah_hari']) ?>

                            </div>

                        </td>

                        <!-- AKSI -->

                        <td>

                            <div class="d-flex gap-2">

                                <!-- EDIT -->

                                <a href="index.php?page=barang-edit&id=<?= $data['id'] ?>"
                                    class="btn btn-warning btn-action">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- HAPUS -->

                                <button type="button" class="btn btn-danger btn-action btn-delete"
                                    data-href="index.php?page=barang-hapus&id=<?= $data['id'] ?>">
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

        let table = $('#tableBarang').DataTable({

            responsive: true,

            autoWidth: false,

            pageLength: 10,

            language: {

                search: "_INPUT_",

                searchPlaceholder: "Cari barang...",

                lengthMenu: "Tampilkan _MENU_ data",

                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                paginate: {

                    previous: "‹",

                    next: "›"

                }

            }

        });

        // FIX RESPONSIVE SIDEBAR

        $('#toggleSidebar').on('click', function() {

            setTimeout(function() {

                table.columns.adjust().responsive.recalc();

            }, 300);

        });

    });
</script>

<!-- SWEETALERT -->

<script>
    $(document).on('click', '.btn-delete', function() {

        let href =
            $(this).data('href');

        Swal.fire({

            title: 'Hapus Barang?',

            text: 'Data barang akan dihapus permanen.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc2626',

            cancelButtonColor: '#64748b',

            confirmButtonText: 'Ya, Hapus',

            cancelButtonText: 'Batal',

            borderRadius: 20

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = href;

            }

        });

    });
</script>
