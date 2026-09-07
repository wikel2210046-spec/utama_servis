<!-- Modal Edit Sparepart -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformeditLabel">
                    <i class="fa fa-edit"></i> Edit Data Sparepart
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(site_url('Sparepart/updateData'), ['class' => 'formsimpan', 'enctype' => 'multipart/form-data']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id_sparepart">ID Sparepart</label>
                    <input type="text" name="id_sparepart" id="id_sparepart" class="form-control" 
                        value="<?= esc($id_sparepart) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_sparepart">Nama Sparepart</label>
                    <input type="text" name="nama_sparepart" id="nama_sparepart" class="form-control"
                        value="<?= esc($nama_sparepart) ?>" required>
                </div>

                <div class="form-group">
                    <label for="no_parts">No Parts</label>
                    <input type="text" name="no_parts" id="no_parts" class="form-control"
                        value="<?= esc($no_parts) ?>" required>
                </div>

                <div class="form-group">
                    <label for="foto">Foto Sparepart</label>
                    <?php if (!empty($foto)) : ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/sparepart/' . $foto) ?>" alt="Foto Sparepart" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="fotoLama" value="<?= esc($foto ?? '') ?>">
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                </div>

                    <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="text" name="stok" id="stok" class="form-control"
                        value="<?= esc($stok) ?>" required>
                </div>
                    <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control"
                        value="<?= esc($satuan) ?>" required>
                </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="edit_harga_beli" class="form-control"
                            value="<?= esc($harga_beli) ?>" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual <small class="text-success"></small></label>
                        <input type="number" name="harga_jual" id="edit_harga_jual" class="form-control"
                            value="<?= esc($harga_jual) ?>" readonly style="background-color: #e9ecef;">
                    </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary tombolUpdate">
                    <i class="fa fa-save"></i> Update
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
 $(document).ready(function(){
    $('.formsimpan').submit(function(e){
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function(){
                $('.tombolUpdate').attr('disabled', true);
                $('.tombolUpdate').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response){
                console.log(response);  // Log response for debugging
                if(response.sukses){
                    Swal.fire(
                        'Berhasil',
                        response.sukses, // Show the success message from PHP
                        'success'
                    ).then((result) => {
                        if(result.isConfirmed || result.dismiss === Swal.DismissReason.timer){
                            location.reload(); // Reload the page if confirmed or after a timeout
                        }
                    });
                } else {
                    Swal.fire(
                        'Gagal',
                        response.error || 'Terjadi kesalahan.', // Show error message if available
                        'error'
                    );
                }
                $('.tombolUpdate').attr('disabled', false).html('Update');
            },
            error: function(xhr, thrownError){
                alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError); // Debugging error
                $('.tombolUpdate').attr('disabled', false).html('Update');
            }
        });
    });
});

// Auto-hitung harga jual = harga beli + 20%
$('#edit_harga_beli').on('input', function() {
    var hargaBeli = parseFloat($(this).val()) || 0;
    var hargaJual = Math.round(hargaBeli * 1.2);
    $('#edit_harga_jual').val(hargaJual > 0 ? hargaJual : '');
});

// Ketika modal diBatal
$('#modalformedit').on('hidden.bs.modal', function () {
    location.reload(); // reload halaman
});

</script>
