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

<div class="card">
    <h3 class="card-title px-3 pt-3">Data Transaksi Servis</h3>

    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah">
            <i class="fa fa-plus"></i> Tambah Transaksi
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <form action="<?= site_url('TransaksiServis/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="caritransaksi" id="caritransaksi" class="form-control"
                        placeholder="Cari No Polisi" autofocus>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolcari">Cari</button>
                    </div>
                </div>
            </form>
            <table class="table table-sm table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Kode Booking</th>
                        <th>Tanggal Servis</th>
                        <th>No. Polisi</th>
                        <th>Tipe</th>
                        <th>Pelanggan</th>
                        <th>Mekanik</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th >Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaksi)): ?>
                        <?php $no = 1; ?>
                        <?php foreach ($transaksi as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++; ?></td>
                                <td><?= esc($row['kode_pemesanan'] ?? '-') ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_servis'])) ?></td>
                                <td><?= esc($row['no_polisi'] ?? '-') ?></td>
                                <td><?= esc($row['tipe'] ?? '-') ?></td>
                                <td><?= esc($row['nama_pelanggan'] ?? '-') ?></td>
                                <td><?= esc($row['nama_mekanik'] ?? '-') ?></td>
                                <td><strong>Rp <?= number_format($row['total_biaya'] ?? 0, 0, ',', '.') ?></strong></td>
                                <td>
                                    <?php 
                                        $status = $row['status_pemesanan'] ?? 'proses';
                                        if ($status == 'selesai servis'): 
                                    ?>
                                        <span class="badge badge-success">Selesai Servis</span>
                                    <?php elseif ($status == 'proses'): ?>
                                        <span class="badge badge-warning text-dark">Proses</span>
                                    <?php elseif ($status == 'selesai'): ?>
                                        <span class="badge badge-info">Selesai</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary"><?= ucfirst(esc($status)) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                     <?php if (($row['status_pemesanan'] ?? '') != 'selesai'): ?>
                                        <button onclick="editTransaksi('<?= $row['id_transaksi'] ?>')" class="btn btn-primary btn-sm" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                     <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" title="Sudah Dibayar (Tidak bisa diedit)" disabled>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                     <?php endif; ?>
                                    <a href="<?= base_url('TransaksiServis/detail/' . $row['id_transaksi']) ?>"
                                        class="btn btn-info btn-sm" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <?php if (($row['status_pemesanan'] ?? 'proses') == 'proses'): ?>
                                    <button onclick="selesaiServis('<?= $row['id_transaksi'] ?>')" class="btn btn-success btn-sm" title="Selesai Servis">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <?php endif; ?>
                                    <!-- <button onclick="hapus('<?= $row['id_transaksi'] ?>')" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                    </button> -->

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center text-muted">Belum ada data transaksi servis.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('user', 'paging_data'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Container -->
<div class="viewmodal" style="display: none;"></div>

<script>
    $(document).ready(function () {
        // === Notifikasi Flashdata ===
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                timer: 1500,
                showConfirmButton: false
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>'
            });
        <?php endif; ?>

        // === Tombol Tambah ===
        $('.btntambah').click(function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "<?= site_url('TransaksiServis/formtambah') ?>",
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
        });

    });

    // === Selesai Servis ===
    function selesaiServis(id_transaksi) {
        Swal.fire({
            title: 'Selesai Servis',
            html: 'Apakah servis untuk transaksi <strong>' + id_transaksi + '</strong> sudah selesai?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.value === true) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('TransaksiServis/selesaiServis') ?>",
                    data: {
                        id_transaksi: id_transaksi,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: "json",
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
                            text: 'Terjadi kesalahan sistem: ' + thrownError + ' (' + xhr.status + ')'
                        });
                    }
                });
            }
        });
    }
    function hapus(id_transaksi) {
        Swal.fire({
            title: 'Hapus Transaksi',
            html: 'Yakin ingin menghapus transaksi <strong>' + id_transaksi + '</strong> ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value === true) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('TransaksiServis/hapus') ?>",
                    data: {
                        id_transaksi: id_transaksi
                    },
                    dataType: "json",
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
                            text: 'Terjadi kesalahan sistem: ' + thrownError + ' (' + xhr.status + ')'
                        });
                    }
                });
            }
        });
    }


    // === Lihat Detail ===
    function detail(id_transaksi) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('TransaksiServis/detail') ?>",
            data: { id_transaksi: id_transaksi },
            dataType: "json",
            success: function (response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modaldetail').modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    // === Edit Transaksi ===
    function editTransaksi(id_transaksi) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('TransaksiServis/formedit') ?>",
            data: { id_transaksi: id_transaksi },
            dataType: "json",
            success: function (response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalformedit').modal('show');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>

<?= $this->endSection() ?>