<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalformtambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformtambahLabel">Tambah Data Uang Keluar</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formuangkeluar">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pengeluaran">Jenis Pengeluaran</label>
                        <input type="text" name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                    </div>  
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
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
    $.ajax({
        type: "POST",
        url: "<?= site_url('Uangkeluar/simpan') ?>",
        data: $('#formuangkeluar').serialize(),
        dataType: "json",
        success: function(response) {
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
            Swal.fire({
                title: 'Error',
                text: 'Terjadi kesalahan pada server: ' + xhr.status + '\n' + xhr.responseText,
                icon: 'error'
            });
        }
    });
});
</script>
