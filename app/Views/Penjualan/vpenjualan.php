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

<div class="card shadow-sm mt-3">
    <h3 class="card-title px-3 pt-3">Data Penjualan Sparepart</h3>

    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <button type="button" class="btn btn-primary btntambah" onclick="tambah()">
                <i class="fa fa-plus"></i> Tambah Penjualan
            </button>
        </div>

        <div class="table-responsive">
            <form action="<?= site_url('Penjualansparepart/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="caripenjualan" id="caripenjualan" class="form-control"
                        placeholder="Cari berdasarkan kode, pelanggan, atau sparepart..." autofocus
                        value="<?= esc($keyword ?? '') ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolcari">
                            </i> Cari
                        </button>
                        <!-- <button type="button" class="btn btn-secondary" onclick="resetCari()">
                            <i class="fa fa-refresh"></i> Reset
                        </button> -->
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered align-middle">
                <thead class="thead-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Penjualan</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total (Rp)</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataPenjualan)): ?>
                        <?php $no = 1 + ($noHalaman - 1) * 5; ?>
                        <?php foreach ($dataPenjualan as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><span class="badge badge-info"><?= esc($row['kode_penjualan']) ?></span></td>
                                <td><?= esc(date('d-m-Y', strtotime($row['tanggal_penjualan']))) ?></td>
                                <td><?= esc($row['nama_pelanggan']) ?></td>
                                <td class="text-end"><?= number_format($row['total_penjualan'] ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <!-- Tombol Invoice -->
                                    <a href="<?= base_url('Penjualansparepart/invoice/' . $row['id_penjualan']) ?>"
                                        target="_blank" class="btn btn-success btn-sm" title="Cetak Invoice">
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <!-- <a href="<?= base_url('penjualansparepart/detail/' . $row['id_penjualan']) ?>" 
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a> -->
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="hapus('<?= $row['id_penjualan'] ?>')" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                <i class="fa fa-info-circle"></i> Belum ada data penjualan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('penjualan', 'paging_data'); ?>
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
    function tambah() {
        $.ajax({
            type: "POST",
            url: "<?= site_url('Penjualansparepart/formtambah') ?>",
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

    function hapus(id_penjualan) {
        Swal.fire({
            title: 'Hapus Data',
            text: "Yakin ingin menghapus data penjualan ini? Stok akan dikembalikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('Penjualansparepart/hapus') ?>",
                    data: {
                        id_penjualan: id_penjualan
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
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            Swal.fire('Gagal', response.error || 'Terjadi kesalahan sistem.', 'error');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

    function resetCari() {
        $('#caripenjualan').val('');
        $.ajax({
            url: "<?= site_url('Penjualansparepart/index') ?>",
            type: "POST",
            data: { tombolcari: true, caripenjualan: '' },
            success: function () {
                window.location.reload();
            }
        });
    }
</script>

<?= $this->endSection() ?>