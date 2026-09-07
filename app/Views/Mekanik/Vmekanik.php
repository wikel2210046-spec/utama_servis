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
    <h3 class="card-title px-3 pt-3">Data Mekanik</h3>

    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah" onclick="tambah()">
            <i class="fa fa-plus"></i> Tambah Data
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <form action="<?= site_url('Mekanik/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="carimekanik" id="carimekanik" class="form-control" placeholder="Cari Nama Mekanik" autofocus>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolmekanik">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <!-- <th>ID mekanik</th> -->
                        <th>Nama mekanik</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($Mekanik)) : ?>
                    <?php $nomor = 1 + ((isset($noHalaman) ? $noHalaman : 1) - 1) * 5;?>
                <?php foreach ($Mekanik as $row) : ?>
                            <tr class="text-center">
                                <td><?= $nomor++; ?></td>
                                <!-- <td><?= esc($row['id_mekanik']); ?></td> -->
                                <td><?= esc($row['nama_mekanik']); ?></td>
                                <td><?= esc($row['alamat']); ?></td>
                                <td><?= esc($row['no_hp']);?></td>
                                <td>
                                    <?php if ($row['status'] === 'aktif') : ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="edit('<?= $row['id_mekanik'] ?>')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $row['id_mekanik'] ?>','<?= $row['nama_mekanik'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data mekanik.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('mekanik', 'paging_data');?>
            </div>
        </div>
    </div>
</div>

<!-- Modal container -->
<div class="viewmodal" style="display: none;"></div>
<div class="viewmodaledit" style="display: none;"></div>
<script>
 $(document).ready(function() {
        console.log('Document ready');
        
        $('.btntambah').click(function(e) {
            e.preventDefault();
            console.log('Button clicked');
            
            $.ajax({
                type: "POST",
                url: "<?= site_url('Mekanik/formtambah') ?>",
                dataType: "json",
                success: function(response) {
                    console.log('Ajax success:', response);
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modalformtambah').modal('show');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log('Ajax error:', xhr.responseText);
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

// Fungsi Edit Data
function edit(id_mekanik) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('Mekanik/formEdit') ?>",
        data: { id_mekanik: id_mekanik },
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

    function hapus(id_mekanik, nama_mekanik) {
    console.log('Mengeksekusi SweetAlert2 untuk menghapus mekanik: ', nama_mekanik);
    Swal.fire({
        title: 'Hapus Mekanik',
        html: 'Yakin Hapus Mekanik <strong>' + nama_mekanik + '</strong> ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        console.log(result.value);
        if (result.value === true) {
            console.log('Konfirmasi untuk hapus: ', id_mekanik);
            $.ajax({
                type: 'POST',
                url: '<?= site_url('Mekanik/hapus') ?>',
                data: {
                    id_mekanik: id_mekanik
                },
                dataType: 'json',
                success: function (response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.sukses,
                            timer: 1500,
                        });
                        window.location.reload(); // Reload halaman untuk merefresh data
                    }
                },
                error: function (xhr, thrownError) {
                    console.log('AJAX error:', xhr.status, thrownError);
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
        $('#carimekanik').val('');
        $('#formCari')[0].reset();
        window.location = '<?= site_url('Mekanik/index') ?>';
    }


</script>
<?= $this->endSection() ?>
