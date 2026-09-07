<!-- Modal Registrasi -->
<div class="modal fade" id="modalDaftar" tabindex="-1" aria-labelledby="modalDaftarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content shadow-lg border-0 rounded-3">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalDaftarLabel">Daftar Akun Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
        <form id="formRegistrasi">
          <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Lengkap</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder="Masukkan nama lengkap" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email aktif" required>
          </div>
          <div class="mb-3">
            <label for="no_hp" class="form-label">No. HP</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="Masukkan nomor HP">
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat"></textarea>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
          </div>
          <div class="mb-3">
            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Daftar</button>
          </div>
        </form>

        <div class="mt-3 text-center">
          <small>
            Sudah punya akun?
              <a href="#" class="text-primary fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</a>
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$('#formRegistrasi').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "<?= site_url('/Login/registrasi') ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(res){
            if(res.success){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message
                });
                $('#modalDaftar').modal('hide');
                $('#formRegistrasi')[0].reset();
                $('#modalLogin').modal('show');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: res.message
                });
            }
        },
        error: function(xhr, status, error){
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Terjadi kesalahan saat registrasi.'
            });
            console.error(error);
        }
    });
});

</script>
