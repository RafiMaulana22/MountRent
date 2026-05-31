<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM kategori
    ORDER BY id DESC
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Data Kategori

        </h2>

        <p class="page-subtitle">

            Kelola kategori perlengkapan rental outdoor

        </p>

    </div>

    <a href="index.php?page=kategori-tambah" class="btn btn-success btn-modern">
        <i class="bi bi-plus-circle me-2"></i>

        Tambah Kategori
    </a>

</div>

<!-- CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tableKategori">

                <thead>

                    <tr>

                        <th width="8%">
                            No
                        </th>

                        <th>
                            Nama Kategori
                        </th>

                        <th width="18%">
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

                        <td>

                            <span class="table-number">

                                <?= $no++ ?>

                            </span>

                        </td>

                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="category-icon">

                                    <i class="bi bi-tags-fill"></i>

                                </div>

                                <div class="fw-semibold">

                                    <?= $data['nama_kategori'] ?>

                                </div>

                            </div>

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <!-- EDIT -->

                                <a href="index.php?page=kategori-edit&id=<?= $data['id'] ?>"
                                    class="btn btn-warning btn-action">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- HAPUS -->

                                <button type="button" class="btn btn-danger btn-action btn-delete"
                                    data-href="index.php?page=kategori-hapus&id=<?= $data['id'] ?>">
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

        let table = $('#tableKategori').DataTable({

            responsive: true,

            autoWidth: false,

            pageLength: 10,

            language: {

                search: "_INPUT_",

                searchPlaceholder: "Cari kategori...",

                lengthMenu: "Tampilkan _MENU_ data",

                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                paginate: {

                    previous: "‹",

                    next: "›"

                }

            }

        });

        // SIDEBAR TOGGLE FIX

        $('#toggleSidebar').on('click', function() {

            setTimeout(function() {

                table.columns.adjust().responsive.recalc();

            }, 300);

        });

    });
</script>

<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-delete', function() {

            let href =
                $(this).data('href');

            Swal.fire({

                title: 'Hapus Kategori?',

                text: 'Data kategori akan dihapus permanen.',

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

    });
</script>
