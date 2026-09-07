<!-- Modal Edit Pemasok -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformeditLabel">
                    <i class="fa fa-edit"></i> Edit Data Pemasok
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(site_url('Pemasok/updateData'), ['class' => 'formsimpan', 'enctype' => 'multipart/form-data']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id_pemasok">ID Pemasok</label>
                    <input type="text" name="id_pemasok" id="id_pemasok" class="form-control" 
                        value="<?= esc($id_pemasok) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_pemasok">Nama Pemasok</label>
                    <input type="text" name="nama_pemasok" id="nama_pemasok" class="form-control"
                        value="<?= esc($nama_pemasok) ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control"
                        value="<?= esc($alamat) ?>" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                        value="<?= esc($no_hp) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="<?= esc($email) ?>" required>
                </div>
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
                console.log(response);
                if(response.sukses){
                    Swal.fire(
                        'Berhasil',
                        response.sukses,
                        'success'
                    ).then((result) => {
                        if(result.isConfirmed || result.dismiss === Swal.DismissReason.timer){
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire(
                        'Gagal',
                        response.error || 'Terjadi kesalahan.',
                        'error'
                    );
                }
                $('.tombolUpdate').attr('disabled', false).html('<i class="fa fa-save"></i> Update');
            },
            error: function(xhr, thrownError){
                alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError);
                $('.tombolUpdate').attr('disabled', false).html('<i class="fa fa-save"></i> Update');
            }
        });
    });
});

// Reload halaman setelah modal ditutup
$('#modalformedit').on('hidden.bs.modal', function () {
    location.reload();
});
</script>
