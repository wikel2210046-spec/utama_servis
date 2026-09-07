<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalformeditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformeditLabel">
                    <i class="fa fa-edit"></i> Edit Data Uang Keluar
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open(site_url('Uangkeluar/updateData'), ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="id_uang_keluar">ID Uang Keluar</label>
                    <input type="text" name="id_uang_keluar" id="id_uang_keluar" class="form-control" 
                        value="<?= esc($id_uang_keluar) ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        value="<?= esc($tanggal) ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="jenis_pengeluaran">Jenis Pengeluaran</label>
                    <input type="text" name="jenis_pengeluaran" id="jenis_pengeluaran" class="form-control"
                        value="<?= esc($jenis_pengeluaran) ?>" required>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                        value="<?= esc($jumlah) ?>" required>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"><?= esc($keterangan) ?></textarea>
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

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function(){
                $('.tombolUpdate').attr('disabled', true);
                $('.tombolUpdate').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function(response){
                if(response.sukses){
                    Swal.fire(
                        'Berhasil',
                        response.sukses,
                        'success'
                    ).then((result) => {
                        window.location.reload(); 
                    });
                } else {
                    Swal.fire(
                        'Gagal',
                        response.error || 'Terjadi kesalahan.', 
                        'error'
                    );
                }
                $('.tombolUpdate').attr('disabled', false).html('Update');
            },
            error: function(xhr, thrownError){
                alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError); 
                $('.tombolUpdate').attr('disabled', false).html('Update');
            }
        });
    });
});

$('#modalformedit').on('hidden.bs.modal', function () {
    location.reload(); 
});
</script>
