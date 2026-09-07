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
    <h3 class="card-title px-3 pt-3">Data Sparepart</h3>

    <div class="card-header">
        <button type="button" class="btn btn-primary btntambah" onclick="tambah()">
            <i class="fa fa-plus"></i> Tambah Data
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <form action="<?= site_url('Sparepart/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="cariSparepart" id="cariSparepart" class="form-control" placeholder="Cari Nama Sparepart" autofocus>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolSparepart">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <!-- <th>ID Sparepart</th> -->
                        <th>Nama Sparepart</th>
                        <th>No Parts</th>
                        <th>Foto</th>
                        <th>Stok</th>  
                        <th>Satuan</th>  
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>         
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($Sparepart)) : ?>
                    <?php $nomor = 1 + ((isset($noHalaman) ? $noHalaman : 1) - 1) * 5;?>
                <?php foreach ($Sparepart as $row) : ?>
                            <tr class="text-center">
                                <td><?= $nomor++; ?></td>
                                <!-- <td><?= esc($row['id_sparepart']); ?></td> -->
                                <td><?= esc($row['nama_sparepart']); ?></td>
                                <td><?= esc($row['no_parts']); ?></td>
                                <td>
                                    <?php if (!empty($row['foto'])) : ?>
                                        <img src="<?= base_url('uploads/sparepart/' . $row['foto']) ?>" alt="Foto" style="max-height: 50px;">
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['stok']); ?></td>
                                <td><?= esc($row['satuan']); ?></td>
                                <td><?= esc($row['harga_beli']); ?></td>
                                <td><?= esc($row['harga_jual']); ?></td>
                               <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="edit('<?= $row['id_sparepart'] ?>')">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $row['id_sparepart'] ?>','<?= $row['nama_sparepart'] ?>')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada data Sparepart.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="float-center">
                <?= $pager->links('sparepart', 'paging_data');?>
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
                url: "<?= site_url('Sparepart/formtambah') ?>",
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
function edit(id_sparepart) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('Sparepart/formEdit') ?>",
        data: { id_sparepart: id_sparepart },
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

    function hapus(id_sparepart, nama_sparepart) {
    console.log('Mengeksekusi SweetAlert2 untuk menghapus Sparepart: ', nama_sparepart);
    Swal.fire({
        title: 'Hapus Sparepart',
        html: 'Yakin Hapus Sparepart <strong>' + nama_sparepart + '</strong> ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        console.log(result.value);
        if (result.value === true) {
            console.log('Konfirmasi untuk hapus: ', id_sparepart);
            $.ajax({
                type: 'POST',
                url: '<?= site_url('Sparepart/hapus') ?>',
                data: {
                    id_sparepart: id_sparepart
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
                        window.location.reload(); 
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
        $('#cariSparepart').val('');
        $('#formCari')[0].reset();
        window.location = '<?= site_url('Sparepart/index') ?>';
    }
</script>
<?= $this->endSection() ?>
