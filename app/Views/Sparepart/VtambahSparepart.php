<!-- Modal -->
<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalformtambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformtambahLabel">Tambah Data Sparepart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formsparepart" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nama_sparepart">Nama sparepart</label>
                        <input type="text" name="nama_sparepart" id="nama_sparepart" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_parts">No Parts</label>
                        <input type="text" name="no_parts" id="no_parts" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Sparepart</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF (Opsional)</small>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" name="stok" id="stok" class="form-control" required>
                    </div>  
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" name="satuan" id="satuan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual <small class="text-success"></small></label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" readonly style="background-color: #e9ecef;">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnsimpan">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$('#btnsimpan').click(function() {
    var formData = new FormData($('#formsparepart')[0]);

    $.ajax({
        type: "POST",
        url: "<?= site_url('sparepart/simpan') ?>",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response) {
            console.log('Response:', response);

            if (response.success) {
                Swal.fire({
                    title: 'Berhasil',
                    text: response.message,
                    icon: 'success'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal',
                    text: response.message || 'Terjadi kesalahan.',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.error('Error:', xhr.status, xhr.responseText, thrownError);

            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan pada server: ' + xhr.status + '\n' + xhr.responseText,
                icon: 'error'
            });
        }
    });
});
// Auto-hitung harga jual = harga beli + 20%
$('#formsparepart #harga_beli').on('input', function() {
    var hargaBeli = parseFloat($(this).val()) || 0;
    var hargaJual = Math.round(hargaBeli * 1.2);
    $('#formsparepart #harga_jual').val(hargaJual > 0 ? hargaJual : '');
});

</script>
