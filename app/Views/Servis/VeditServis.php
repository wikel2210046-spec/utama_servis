<!-- Modal Edit servis -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformeditLabel">
                    <i class="fa fa-edit"></i> Edit Data Servis
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(site_url('Servis/updateData'), ['class' => 'formsimpan', 'enctype' => 'multipart/form-data']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id_servis">ID Servis</label>
                    <input type="text" name="id_servis" id="id_servis" class="form-control" 
                        value="<?= esc($id_servis) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_servis">Nama servis</label>
                    <input type="text" name="nama_servis" id="nama_servis" class="form-control"
                        value="<?= esc($nama_servis) ?>" required>
                </div>
                    <div class="form-group">
                    <label for="harga_servis">Harga</label>
                    <input type="text" name="harga_servis" id="harga_servis" class="form-control"
                        value="<?= esc($harga_servis) ?>" required>
                </div>
                    <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                        value="<?= esc($deskripsi) ?>" required>
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

// Ketika modal diBatal
$('#modalformedit').on('hidden.bs.modal', function () {
    location.reload(); // reload halaman
});

</script>
