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
    <h3 class="card-title px-3 pt-3">Data Pemasok</h3>

    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah">
            <i class="fa fa-plus"></i> Tambah Data
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <form action="<?= site_url('Pemasok/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="caripemasok" id="caripemasok" class="form-control" placeholder="Cari Nama Pemasok" value="<?= esc($cari) ?>" autofocus>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolpemasok">Cari</button>
                        <!-- <button type="button" class="btn btn-secondary" onclick="resetCari()">Reset</button> -->
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <!-- <th>ID Pemasok</th> -->
                        <th>Nama Pemasok</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($Pemasok)) : ?>
                        <?php $nomor = 1 + ((isset($noHalaman) ? $noHalaman : 1) - 1) * 5; ?>
                        <?php foreach ($Pemasok as $row) : ?>
                            <tr class="text-center">
                                <td><?= $nomor++; ?></td>
                                <!-- <td><?= esc($row['id_pemasok']); ?></td> -->
                                <td><?= esc($row['nama_pemasok']); ?></td>
                                <td><?= esc($row['alamat']); ?></td>
                                <td><?= esc($row['no_hp']); ?></td>
                                <td><?= esc($row['email']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="edit('<?= $row['id_pemasok'] ?>')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $row['id_pemasok'] ?>','<?= $row['nama_pemasok'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data pemasok.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('pemasok', 'paging_data'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal container -->
<div class="viewmodal" style="display: none;"></div>
<div class="viewmodaledit" style="display: none;"></div>

<script>
$(document).ready(function() {
    // Tombol Tambah
    $('.btntambah').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= site_url('Pemasok/formtambah') ?>",
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

// Fungsi Edit Data
function edit(id_pemasok) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('Pemasok/formEdit') ?>",
        data: { id_pemasok: id_pemasok },
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

// Fungsi Hapus Data
function hapus(id_pemasok, nama_pemasok) {
    Swal.fire({
        title: 'Hapus Pemasok',
        html: 'Yakin hapus pemasok <strong>' + nama_pemasok + '</strong> ?',
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
                url: '<?= site_url('Pemasok/hapus') ?>',
                data: { id_pemasok: id_pemasok },
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.sukses,
                            timer: 1500,
                        });
                        window.location.reload();
                    }
                },
                error: function(xhr, thrownError) {
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

// Fungsi Reset Pencarian
function resetCari() {
    $('#caripemasok').val('');
    $('#formCari')[0].reset();
    window.location = '<?= site_url('Pemasok/index') ?>';
}
</script>

<?= $this->endSection() ?>
