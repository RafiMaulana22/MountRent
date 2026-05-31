<?php

include 'config/koneksi.php';

$query = mysqli_query(
    $conn,
    "
    SELECT
        transaksi.*,
        penyewa.nama

    FROM transaksi

    JOIN penyewa
    ON transaksi.penyewa_id = penyewa.id

    ORDER BY transaksi.id DESC
",
);

?>

<!-- PAGE HEADER -->

<div class="page-header mb-4">

    <div>

        <h2 class="page-title">

            Transaksi Penyewaan

        </h2>

        <p class="page-subtitle">

            Kelola transaksi penyewaan perlengkapan outdoor

        </p>

    </div>

    <a href="index.php?page=transaksi-tambah" class="btn btn-success btn-modern">
        <i class="bi bi-plus-circle me-2"></i>

        Tambah Transaksi
    </a>

</div>

<!-- CARD -->

<div class="card modern-card border-0">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table class="table align-middle" id="tableTransaksi">

                <thead>

                    <tr>

                        <th width="5%">
                            No
                        </th>

                        <th>
                            Kode
                        </th>

                        <th>
                            Penyewa
                        </th>

                        <th>
                            Tanggal Sewa
                        </th>

                        <th>
                            Tanggal Kembali
                        </th>

                        <th>
                            Total
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

                        <!-- KODE -->

                        <td>

                            <div class="transaction-code">

                                <i class="bi bi-receipt-cutoff"></i>

                                <?= $data['kode_transaksi'] ?>

                            </div>

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

                                        Customer Rental

                                    </small>

                                </div>

                            </div>

                        </td>

                        <!-- TANGGAL SEWA -->

                        <td>

                            <div class="date-box-modern">

                                <i class="bi bi-calendar-check-fill"></i>

                                <?= date('d M Y', strtotime($data['tanggal_sewa'])) ?>

                            </div>

                        </td>

                        <!-- TANGGAL KEMBALI -->

                        <td>

                            <div class="date-box-modern return-date">

                                <i class="bi bi-calendar2-week-fill"></i>

                                <?= date('d M Y', strtotime($data['tanggal_kembali'])) ?>

                            </div>

                        </td>

                        <!-- TOTAL -->

                        <td>

                            <div class="price-box">

                                Rp <?= number_format($data['total']) ?>

                            </div>

                        </td>

                        <!-- AKSI -->

                        <td>

                            <div class="d-flex gap-2">

                                <!-- DETAIL -->

                                <a href="
                                        index.php?page=transaksi-detail&id=<?= $data['id'] ?>
                                    "
                                    class="btn btn-info btn-action">
                                    <i class="bi bi-eye-fill"></i>
                                </a>

                                <!-- HAPUS -->

                                <button type="button" class="btn btn-danger btn-action btn-delete"
                                    data-href="
                                        index.php?page=transaksi-hapus&id=<?= $data['id'] ?>
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

        let table =
            $('#tableTransaksi').DataTable({

                responsive: true,

                autoWidth: false,

                pageLength: 10,

                language: {

                    search: "_INPUT_",

                    searchPlaceholder: "Cari transaksi...",

                    lengthMenu: "Tampilkan _MENU_ data",

                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",

                    paginate: {

                        previous: "‹",

                        next: "›"
                    }
                }

            });

        // FIX RESPONSIVE

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

                    title: 'Hapus Transaksi?',

                    text: 'Data transaksi akan dihapus permanen.',

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
