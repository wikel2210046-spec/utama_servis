<!-- Modal Edit Admin -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformeditLabel">
                    <i class="fa fa-edit"></i> Edit Data Admin
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(site_url('Admin/updateData'), ['class' => 'formsimpan', 'enctype' => 'multipart/form-data']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id_admin">ID Admin</label>
                    <input type="text" name="id_admin" id="id_admin" class="form-control" 
                        value="<?= esc($id_admin) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control"
                        value="<?= esc($nama) ?>" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        value="<?= esc($username) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (opsional)</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                </div>

                <div class="form-group">
                    <label for="level">Level</label>
                    <select name="level" id="level" class="form-control" required>
                        <option value="1" <?= esc($level == 1) ? 'selected' : '' ?>>Admin</option>
                        <option value="2" <?= esc($level == 2) ? 'selected' : '' ?>>Pimpinan</option>
                    </select>
                </div>
                <div class="form-group"></div>
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih status --</option>
                            <option value="Aktif" <?= esc($status) === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?= esc($status) === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>

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
