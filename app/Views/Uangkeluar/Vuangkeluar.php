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
    <h3 class="card-title px-3 pt-3">Data Uang Keluar</h3>

    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah" onclick="tambah()">
            <i class="fa fa-plus"></i> Tambah Data
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <form action="<?= site_url('Uangkeluar/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="cariUangkeluar" id="cariUangkeluar" class="form-control" placeholder="Cari Jenis Pengeluaran / Keterangan" value="<?= esc($cari) ?>" autofocus>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolUangkeluar">Cari</button>
                        <!-- <button type="button" class="btn btn-secondary" onclick="resetCari()">Reset</button> -->
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Jenis Pengeluaran</th>
                        <th>Jumlah (Rp)</th>
                        <th>Keterangan</th>         
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($uang_keluar)) : ?>
                    <?php $nomor = 1 + ((isset($noHalaman) ? $noHalaman : 1) - 1) * 10;?>
                <?php foreach ($uang_keluar as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $nomor++; ?></td>
                                <td class="text-center"><?= esc(date('d-m-Y', strtotime($row['tanggal']))); ?></td>
                                <td class="text-center"><?= esc($row['jenis_pengeluaran']); ?></td>
                                <td class="text-center"><?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?= esc($row['keterangan']); ?></td>
                               <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" title="Edit" onclick="edit('<?= $row['id_uang_keluar'] ?>')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="hapus('<?= $row['id_uang_keluar'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data Uang Keluar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('uang_keluar', 'paging_data');?>
            </div>
        </div>
    </div>
</div>

<!-- Modal container -->
<div class="viewmodal" style="display: none;"></div>
<div class="viewmodaledit" style="display: none;"></div>

<script>
$(document).ready(function() {
    $('.btntambah').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= site_url('Uangkeluar/formtambah') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalformtambah').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});

function edit(id_uang_keluar) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('Uangkeluar/formEdit') ?>",
        data: { id_uang_keluar: id_uang_keluar },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodaledit').html(response.data).show();
                $('#modalformedit').modal('show');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

function hapus(id_uang_keluar) {
    Swal.fire({
        title: 'Hapus Data',
        html: 'Yakin Hapus Data Pengeluaran ini?',
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
                url: '<?= site_url('Uangkeluar/hapus') ?>',
                data: {
                    id_uang_keluar: id_uang_keluar
                },
                dataType: 'json',
                success: function (response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.sukses,
                            timer: 1500,
                        }).then(() => {
                            window.location.reload(); 
                        });
                    }
                },
                error: function (xhr, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menghapus data.',
                        timer: 1500,
                    });
                }
            });
        }
    });
}

function resetCari() {
    $('#cariUangkeluar').val('');
    $('#formCari')[0].reset();
    window.location = '<?= site_url('Uangkeluar/index') ?>';
}
</script>
<?= $this->endSection() ?>
