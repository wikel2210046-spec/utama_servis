<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card shadow">
    <h3 class="card-title px-3 pt-3">Data Pemesanan Servis</h3>
    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah" onclick="tambah()">
            <i class="fa fa-plus"></i> Tambah Data
        </button>
    </div>

    <div class="card-body">
        <form action="<?= site_url('Pemesanan/index') ?>" method="post" id="formCari">
            <?= csrf_field() ?>
            <div class="input-group mb-3">
                <input type="text" name="caripemesanan" id="caripemesanan" class="form-control"
                    placeholder="Cari Nama Pelanggan/Kode Pesan" autofocus>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" name="tombolPemesanan">Cari</button>
                </div>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-center align-middle">
                <thead class="thead-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode Pemesanan</th>
                                <th>Tanggal Servis</th>
                                <th>Jam Servis</th>
                                <th>Nama Pelanggan</th>
                                <th>No Hp</th>
                                <th>Tipe</th>
                                <th>Warna</th>
                                <th>No Polisi</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                                <th width="5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pemesanan)): ?>
                                <?php $nomor = 1 + ((isset($noHalaman) ? $noHalaman : 1) - 1) * 5; ?>
                                <?php foreach ($pemesanan as $row): ?>
                                    <tr>
                                        <td><?= $nomor++; ?></td>
                                        <td><?= esc($row['kode_pemesanan']) ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['tanggal_servis'])) ?></td>
                                        <td><?= esc($row['jam_servis']) ?></td>
                                        <td><?= esc($row['nama_pelanggan']) ?></td>
                                        <td><?= esc($row['no_hp']) ?></td>
                                        <td><?= esc($row['tipe']) ?></td>
                                        <td><?= esc($row['warna']) ?></td>
                                        <td><?= esc($row['no_polisi']) ?></td>
                                        <td><?= esc($row['keluhan']) ?></td>
                                        <td>
                                            <?php if ($row['status'] == 'pesan'): ?>
                                                <span class="badge badge-warning">Pesan</span>
                                            <?php elseif ($row['status'] == 'proses'): ?>
                                                <span class="badge badge-primary">Proses</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Selesai</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($row['status'] == 'pesan'): ?>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapus('<?= $row['id_pemesanan'] ?>','<?= esc($row['nama_pelanggan']) ?>')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                            <!-- <br>
                                            <?php if ($row['status'] != 'proses'): ?>
                                                <a href="<?= base_url('Pemesanan/ubahStatus/' . $row['id_pemesanan'] . '/proses') ?>"
                                                    class="btn btn-sm btn-outline-info mt-1">
                                                    <i class="fa fa-cogs"></i> Proses
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($row['status'] != 'selesai'): ?>
                                                <a href="<?= base_url('Pemesanan/ubahStatus/' . $row['id_pemesanan'] . '/selesai') ?>"
                                                    class="btn btn-sm btn-outline-success mt-1">
                                                    <i class="fa fa-check"></i> Selesai
                                                </a>
                                            <?php endif; ?> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11" class="text-center text-muted">Belum ada data pemesanan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="float-center mt-3">
                        <?= $pager->links('pemesanan', 'paging_data'); ?>
                    </div>
                </div>
    </div>
</div>

        <!-- Modal container -->
        <div class="viewmodal" style="display: none;"></div>
        <div class="viewmodaledit" style="display: none;"></div>

        <script>
            // Tambah Data
            function tambah() {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Pemesanan/formTambah') ?>",
                    dataType: "json",
                    success: function (response) {
                        if (response.data) {
                            $('.viewmodal').html(response.data).show();
                            $('#modalformtambah').modal('show');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }

            function hapus(id_pemesanan, nama_pelanggan) {
                Swal.fire({
                    title: 'Hapus Pemesanan',
                    html: 'Yakin hapus pemesanan <strong>' + nama_pelanggan + '</strong> ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.value === true) {
                        $.ajax({
                            type: 'POST',
                            url: '<?= site_url('Pemesanan/hapus') ?>',
                            data: {
                                id_pemesanan: id_pemesanan
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.sukses) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.sukses,
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                } else if (response.error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: response.error
                                    });
                                }
                            },
                            error: function (xhr, thrownError) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan sistem: ' + thrownError + ' (' + xhr.status + ')',
                                });
                            }
                        });
                    }
                });
            }

            // Reset Pencarian
            function resetCari() {
                $('#caripemesanan').val('');
                $('#formCari')[0].reset();
                window.location = '<?= site_url('Pemesanan/index') ?>';
            }
        </script>

        <style>
            .table th,
            .table td {
                vertical-align: middle !important;
            }

            .card {
                border-radius: 10px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 13px;
            }

            .badge {
                font-size: 0.85rem;
                padding: 6px 10px;
            }
        </style>

        <?= $this->endSection() ?>