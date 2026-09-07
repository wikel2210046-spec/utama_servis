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
    <h3 class="card-title px-3 pt-3">Data Pembelian Sparepart</h3>

    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah" onclick="tambah()">
            <i class="fa fa-plus"></i> Tambah Pembelian
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <!-- Tombol Cari (versi aslimu) -->
            <form action="<?= site_url('Pembeliansparepart/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="caripembelian" id="caripembelian" class="form-control"
                        placeholder="Cari berdasarkan nama pemasok..." autofocus value="<?= esc($cari ?? '') ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolcari">
                            <i class="fa fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered align-middle">
                <thead class="thead-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Pembelian</th>
                        <th>Tanggal Pembelian</th>
                        <th>Nama Pemasok</th>
                        <th>Total Pembelian (Rp)</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataPembelian)): ?>
                        <?php $no = 1 + ((isset($noHalaman) ? $noHalaman : 1) - 1) * 5; ?>
                        <?php foreach ($dataPembelian as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['kode_pembelian']) ?></td>
                                <td><?= esc(date('d-m-Y', strtotime($row['tanggal_pembelian']))) ?></td>
                                <td><?= esc($row['nama_pemasok']) ?></td>
                                <td class="text-end"><?= number_format($row['total_pembelian'] ?? 0, 0, ',', '.') ?></td>
                                <td>
                                    <a href="<?= base_url('pembeliansparepart/detail/' . $row['id_pembelian']) ?>"
                                        class="btn btn-info btn-sm" title="Detail">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="hapus('<?= $row['id_pembelian'] ?>')" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                <i class="fa fa-info-circle"></i> Belum ada data pembelian.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="float-center">
                <?= $pager->links('pembelian', 'paging_data'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Container -->
<div class="viewmodal" style="display: none;"></div>
<div class="viewmodaldetail" style="display: none;"></div>

<script>
    // Tambah Pembelian
    function tambah() {
        $.ajax({
            type: "POST",
            url: "<?= site_url('Pembeliansparepart/formtambah') ?>",
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

    // Hapus Pembelian
    function hapus(id_pembelian) {
        Swal.fire({
            title: 'Hapus Data',
            text: "Yakin ingin menghapus data pembelian ini?",
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
                    url: "<?= site_url('Pembeliansparepart/hapus') ?>",
                    data: { id_pembelian: id_pembelian },
                    dataType: "json",
                    success: function (response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.sukses,
                                timer: 1500,
                            });
                            setTimeout(() => window.location.reload(), 1500);
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
        $('#caripembelian').val('');
        window.location = '<?= site_url('Pembeliansparepart/index') ?>';
    }
</script>

<?= $this->endSection() ?>