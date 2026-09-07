
  <!-- Modal Login -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalLoginLabel">Login</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formLogin">
          <div class="mb-3">
            <label for="username" class="form-label">Username / Email</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username atau email">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
        </form>
        <!-- Tambahan teks daftar -->
        <div class="mt-3 text-center">
          <small>
            Belum punya akun?
             <a href="#" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalDaftar" class="text-primary fw-bold">Daftar</a>
          </small>
        </div>
      </div>
      
    </div>
  </div>
</div>
<?= $this->include('template/Registrasi'); ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$('#formLogin').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: "<?= site_url('/Login/proses') ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(res){
            if(res.success){
                if(res.role === 'admin' || res.role === 'pimpinan'){
                    window.location.href = "<?= site_url('/Dashboard/dashboard') ?>";
                } else {
                    window.location.href = "<?= site_url('/') ?>"; // halaman utama pelanggan
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login',
                    text: res.message
                });
            }
        },
        error: function(xhr, status, error){
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan',
                text: 'Terjadi kesalahan saat login.'
            });
        }
    });
});

</script>