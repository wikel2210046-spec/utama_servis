<!-- Modal -->
<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalformtambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformtambahLabel">Tambah Data Jenis Servis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formservis">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nama_servis">Nama servis</label>
                        <input type="text" name="nama_servis" id="nama_servis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_servis">Harga</label>
                        <input type="text" name="harga_servis" id="harga_servis" class="form-control" required>
                    </div> 
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
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
    console.log($('#formservis').serialize());

    $.ajax({
        type: "POST",
        url: "<?= site_url('Servis/simpan') ?>",
        data: $('#formservis').serialize(),
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
