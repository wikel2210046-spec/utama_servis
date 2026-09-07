<!-- Modal Edit Pelanggan -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformeditLabel">
                    <i class="fa fa-edit"></i> Edit Data Pelanggan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(site_url('Pelanggan/updateData'), ['class' => 'formsimpan', 'enctype' => 'multipart/form-data']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id_pelanggan">ID Pelanggan</label>
                    <input type="text" name="id_pelanggan" id="id_pelanggan" class="form-control" 
                        value="<?= esc($id_pelanggan) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control"
                        value="<?= esc($nama_pelanggan) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control"
                        value="<?= esc($email) ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password (opsional)</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                </div>
                    <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control"
                        value="<?= esc($alamat) ?>" required>
                </div>
                    <div class="form-group">
                    <label for="no_hp">No Hp</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                        value="<?= esc($no_hp) ?>" required>
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
