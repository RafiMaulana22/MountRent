<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT *
    FROM penyewa
    ORDER BY id DESC
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Data Penyewa

        </h2>

        <p class="page-subtitle">

            Kelola data pelanggan rental outdoor

        </p>

    </div>

    <a href="index.php?page=penyewa-tambah" class="btn btn-success btn-modern">
        <i class="bi bi-plus-circle me-2"></i>

        Tambah Penyewa
    </a>

</div>

<!-- CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tablePenyewa">

                <thead>

                    <tr>

                        <th width="5%">
                            No
                        </th>

                        <th>
                            Penyewa
                        </th>

                        <th>
                            No HP
                        </th>

                        <th>
                            Alamat
                        </th>

                        <th>
                            Catatan
                        </th>

                        <th width="15%">
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

                        <!-- PENYEWA -->

                        <td>

                            <div class="d-flex align-items-center gap-3">

                                <div class="penyewa-avatar">

                                    <?= strtoupper(substr($data['nama'], 0, 1)) ?>

                                </div>

                                <div>

                                    <div class="fw-bold text-dark">

                                        <?= $data['nama'] ?>

                                    </div>

                                    <small class="text-muted">

                                        Penyewa Outdoor

                                    </small>

                                </div>

                            </div>

                        </td>

                        <!-- NO HP -->

                        <td>

                            <div class="contact-box">

                                <i class="bi bi-telephone-fill"></i>

                                <?= $data['no_hp'] ?>

                            </div>

                        </td>

                        <!-- ALAMAT -->

                        <td>

                            <div class="alamat-text">

                                <?= $data['alamat'] ?>

                            </div>

                        </td>

                        <!-- CATATAN -->

                        <td>

                            <?php if($data['catatan'] != '') : ?>

                            <span class="catatan-badge">

                                <?= $data['catatan'] ?>

                            </span>

                            <?php else : ?>

                            <span class="text-muted">

                                -

                            </span>

                            <?php endif; ?>

                        </td>

                        <!-- AKSI -->

                        <td>

                            <div class="d-flex gap-2">

                                <!-- EDIT -->

                                <a href="index.php?page=penyewa-edit&id=<?= $data['id'] ?>"
                                    class="btn btn-warning btn-action">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- HAPUS -->

                                <button type="button" class="btn btn-danger btn-action btn-delete"
                                    data-href="
                                        index.php?page=penyewa-hapus&id=<?= $data['id'] ?>
                                    ">
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

        let table = $('#tablePenyewa').DataTable({

            responsive: true,

            autoWidth: false,

            pageLength: 10,

            language: {

                search: "_INPUT_",

                searchPlaceholder: "Cari penyewa...",

                lengthMenu: "Tampilkan _MENU_ data",

                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                paginate: {

                    previous: "‹",

                    next: "›"
                }
            }

        });

        // FIX SIDEBAR RESPONSIVE

        $('#toggleSidebar').on('click', function() {

            setTimeout(function() {

                table.columns.adjust().responsive.recalc();

            }, 300);

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

                    title: 'Hapus Penyewa?',

                    text: 'Data penyewa akan dihapus permanen.',

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
