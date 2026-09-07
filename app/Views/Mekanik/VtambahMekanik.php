<!-- Modal -->
<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalformtambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformtambahLabel">Tambah Data Mekanik</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formmekanik">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nama_mekanik">Nama mekanik</label>
                        <input type="text" name="nama_mekanik" id="nama_mekanik" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Hp</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
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
    console.log($('#formmekanik').serialize());

    $.ajax({
        type: "POST",
        url: "<?= site_url('Mekanik/simpan') ?>",
        data: $('#formmekanik').serialize(),
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


</script>
