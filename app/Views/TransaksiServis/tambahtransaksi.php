<!-- Modal Tambah Transaksi Servis -->
<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalTransaksiServisLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalTransaksiServisLabel">Transaksi Servis</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <!-- Body -->
      <form id="formTransaksi" action="<?= base_url('TransaksiServis/simpan'); ?>" method="post">
        <?= csrf_field() ?>
        <div class="modal-body">
          <!-- Baris 1 -->
          <div class="form-row mb-3">
            <!-- <div class="col-md-3">
              <label>ID Transaksi</label>
              <input type="text" class="form-control" name="id_transaksi" id="id_transaksi" readonly>
            </div> -->
            <input type="hidden" name="id_pemesanan" id="id_pemesanan">
            <input type="hidden" name="kode_pemesanan" id="kode_pemesanan">
            <div class="col-md-4">
              <label>Nama Pelanggan</label>
              <div class="input-group">
                <input type="text" class="form-control" id="nama_pelanggan" readonly
                  placeholder="Klik Cari untuk pilih pelanggan" required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" id="btnCariPelanggan"><i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <input type="hidden" id="id_pelanggan" name="id_pelanggan">
            </div>
            <div class="col-md-4">
              <label>No HP</label>
              <input type="text" class="form-control" id="no_hp" name="no_hp" readonly>
            </div>
            <div class="col-md-4">
              <label>Tanggal Servis</label>
              <input type="date" class="form-control" name="tanggal_servis" id="tanggal_servis" required>
            </div>
          </div>
          <!-- Baris 2 -->
          <div class="form-row mb-3">
            <div class="col-md-4">
              <label>No Polisi</label>
              <input type="text" class="form-control" id="no_polisi" name="no_polisi" readonly>
            </div>
            <div class="col-md-4">
              <label>Merk</label>
              <input type="text" class="form-control" id="merk_mobil" name="merk_mobil" readonly>
            </div>
            <div class="col-md-2">
              <label>Tipe</label>
              <input type="text" class="form-control" id="tipe_mobil" name="tipe_mobil" readonly>
            </div>
            <div class="col-md-2">
              <label>Warna</label>
              <input type="text" class="form-control" id="warna_mobil" name="warna_mobil" readonly>
            </div>
          </div>
          <!-- Baris 3 -->
          <div class="form-row mb-3">
            <div class="col-md-3">
              <label>Jenis</label>
              <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" readonly>
            </div>
            <div class="col-md-5">
              <label>Keluhan</label>
              <input type="text" class="form-control" id="keluhan" name="keluhan" readonly>
            </div>
            <div class="col-md-4">
              <label>Mekanik</label>
              <div class="input-group">
                <input type="text" class="form-control" id="nama_mekanik" readonly
                  placeholder="Klik Cari untuk pilih mekanik" required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" id="btnCariMekanik"><i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <input type="hidden" id="id_mekanik" name="id_mekanik">
            </div>
          </div>
          <hr>
          <!-- Jasa Servis -->
          <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-secondary text-white"><strong>Jasa Servis</strong></div>
            <div class="card-body">
              <div class="form-row align-items-end mb-3">
                <div class="col-md-6">
                  <label>Pilih Jasa Servis</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nama_servis" readonly
                      placeholder="Klik Cari untuk pilih servis">
                    <input type="hidden" id="id_servis">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-primary" id="btnCariServis"><i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <label>Harga Jasa</label>
                  <input type="text" class="form-control" id="harga_servis" readonly>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-success btn-block" id="btnTambahServis">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <table class="table table-bordered table-sm" id="tabelServis">
                <thead class="thead-light text-center">
                  <tr>
                    <th>Nama Servis</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <!-- Sparepart -->
          <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-secondary text-white"><strong>Sparepart</strong></div>
            <div class="card-body">
              <div class="form-row align-items-end mb-3">
                <div class="col-md-6">
                  <label>Pilih Sparepart</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="nama_sparepart" readonly
                      placeholder="Klik Cari untuk pilih sparepart">
                    <input type="hidden" id="id_sparepart">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-primary" id="btnCariSparepart"><i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <label>Jumlah</label>
                  <input type="number" id="jumlah_sparepart" class="form-control" value="1" min="1">
                </div>
                <div class="col-md-3">
                  <label>Subtotal</label>
                  <input type="text" id="subtotal_sparepart" class="form-control" readonly>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-success btn-block" id="btnTambahSparepart">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <table class="table table-bordered table-sm" id="tabelSparepart">
                <thead class="thead-light text-center">
                  <tr>
                    <th>Nama Sparepart</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
          <div class="form-group mt-3 text-right">
            <label><strong>Total Biaya:</strong></label>
            <input type="text" id="total_biaya" name="total_biaya" class="form-control text-right font-weight-bold"
              readonly>
          </div>
        </div> <!-- /modal-body -->
        <!-- Footer tombol -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i> Batal
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Cari Pelanggan -->
<div class="modal fade" id="modalCariPelanggan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Pelanggan</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariPelanggan" class="form-control mb-2" placeholder="Cari nama atau HP...">

        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariPelanggan">
            <thead class="thead-light">
              <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Merk</th>
                <th>Tipe</th>
                <th>Jenis</th>
                <th>Warna</th>
                <th>No Polisi</th>
                <th>Keluhan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Cari Mekanik -->
<div class="modal fade" id="modalCariMekanik" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Mekanik</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariMekanik" class="form-control mb-2" placeholder="Cari nama mekanik...">
        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariMekanik">
            <thead class="thead-light">
              <tr>
                <th>Nama Mekanik</th>
                <th>no_hp</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

<!-- Modal Cari Servis -->
<div class="modal fade" id="modalCariServis" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Jasa Servis</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariServis" class="form-control mb-2" placeholder="Cari jasa servis...">
        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariServis">
            <thead class="thead-light">
              <tr>
                <th>Nama Servis</th>
                <th>Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

<!-- Modal Cari Sparepart -->
<div class="modal fade" id="modalCariSparepart" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Sparepart</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariSparepart" class="form-control mb-2" placeholder="Cari sparepart...">
        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariSparepart">
            <thead class="thead-light">
              <tr>
                <th>Nama Sparepart</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

<script>
  $(document).ready(function () {
    // === MODAL CARI MEKANIK ===
    $('#btnCariMekanik').click(function () {
      $('#modalCariMekanik').modal('show');
      loadMekanik();
    });

    $('#inputCariMekanik').on('keyup', function () {
      const query = $(this).val();
      loadMekanik(query);
    });

    $(document).on('click', '.btnPilihMekanik', function () {
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      $('#id_mekanik').val(id);
      $('#nama_mekanik').val(nama);
      $('#modalCariMekanik').modal('hide');
    });

    function loadMekanik(query = '') {
      $.ajax({
        url: "<?= site_url('TransaksiServis/getMekanik') ?>",
        method: "GET",
        data: { q: query },
        dataType: "json",
        success: function (res) {
          let rows = '';
          if (res.length === 0) {
            rows = `<tr><td colspan="3" class="text-center text-muted">Tidak ada data mekanik</td></tr>`;
          } else {
            res.forEach(m => {
              rows += `
                      <tr>
                        <td>${m.nama_mekanik}</td>
                        <td>${m.no_hp ?? '-'}</td>
                        <td class="text-center">
                          <button type="button" class="btn btn-success btn-sm btnPilihMekanik"
                            data-id="${m.id_mekanik}"
                            data-nama="${m.nama_mekanik}">
                            Pilih
                          </button>
                        </td>
                      </tr>`;
            });
          }
          $('#tabelCariMekanik tbody').html(rows);
        },
        error: function () {
          $('#tabelCariMekanik tbody').html(
            `<tr><td colspan="3" class="text-center text-danger">Gagal memuat data mekanik</td></tr>`
          );
        }
      });
    }

    // === MODAL CARI SERVIS ===
    $('#btnCariServis').click(function () {
      $('#modalCariServis').modal('show');
      loadServis();
    });

    $('#inputCariServis').on('keyup', function () {
      const query = $(this).val();
      loadServis(query);
    });

    $(document).on('click', '.btnPilihServis', function () {
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const harga = $(this).data('harga');
      $('#id_servis').val(id);
      $('#nama_servis').val(nama);
      $('#harga_servis').val(harga);
      $('#modalCariServis').modal('hide');
    });

    function loadServis(query = '') {
      $.ajax({
        url: "<?= site_url('TransaksiServis/getServis') ?>",
        method: "GET",
        data: { q: query },
        dataType: "json",
        success: function (res) {
          let rows = '';
          if (res.length === 0) {
            rows = `<tr><td colspan="3" class="text-center text-muted">Tidak ada data servis</td></tr>`;
          } else {
            res.forEach(s => {
              rows += `
                      <tr>
                        <td>${s.nama_servis}</td>
                        <td class="text-right">${s.harga_servis}</td>
                        <td class="text-center">
                          <button type="button" class="btn btn-success btn-sm btnPilihServis"
                            data-id="${s.id_servis}"
                            data-nama="${s.nama_servis}"
                            data-harga="${s.harga_servis}">
                            Pilih
                          </button>
                        </td>
                      </tr>`;
            });
          }
          $('#tabelCariServis tbody').html(rows);
        },
        error: function () {
          $('#tabelCariServis tbody').html(
            `<tr><td colspan="3" class="text-center text-danger">Gagal memuat data servis</td></tr>`
          );
        }
      });
    }

    // === MODAL CARI SPAREPART ===
    $('#btnCariSparepart').click(function () {
      $('#modalCariSparepart').modal('show');
      loadSparepart();
    });

    $('#inputCariSparepart').on('keyup', function () {
      const query = $(this).val();
      loadSparepart(query);
    });

    $(document).on('click', '.btnPilihSparepart', function () {
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const harga = $(this).data('harga');
      $('#id_sparepart').val(id);
      $('#nama_sparepart').val(nama);
      // Simpan harga per unit di data attribute untuk perhitungan
      $('#subtotal_sparepart').data('harga-unit', harga);
      // Trigger perhitungan subtotal
      const jumlah = parseInt($('#jumlah_sparepart').val()) || 1;
      $('#subtotal_sparepart').val(harga * jumlah);
      $('#modalCariSparepart').modal('hide');
    });

    function loadSparepart(query = '') {
      $.ajax({
        url: "<?= site_url('TransaksiServis/getSparepart') ?>",
        method: "GET",
        data: { q: query },
        dataType: "json",
        success: function (res) {
          let rows = '';
          if (res.length === 0) {
            rows = `<tr><td colspan="4" class="text-center text-muted">Tidak ada data sparepart</td></tr>`;
          } else {
            res.forEach(sp => {
              rows += `
                      <tr>
                        <td>${sp.nama_sparepart}</td>
                        <td class="text-right">${sp.harga_jual}</td>
                        <td class="text-center">${sp.stok}</td>
                        <td class="text-center">
                          <button type="button" class="btn btn-success btn-sm btnPilihSparepart"
                            data-id="${sp.id_sparepart}"
                            data-nama="${sp.nama_sparepart}"
                            data-harga="${sp.harga_jual}">
                            Pilih
                          </button>
                        </td>
                      </tr>`;
            });
          }
          $('#tabelCariSparepart tbody').html(rows);
        },
        error: function () {
          $('#tabelCariSparepart tbody').html(
            `<tr><td colspan="4" class="text-center text-danger">Gagal memuat data sparepart</td></tr>`
          );
        }
      });
    }

    // === Ambil harga saat pilih servis (TIDAK PERLU LAGI, sudah langsung dari modal) ===
    // $('#id_servis').change(function() {
    //   const harga = $('#id_servis option:selected').data('harga') || 0;
    //   $('#harga_servis').val(harga);
    // });
    // === Tambah servis ke tabel ===
    $('#btnTambahServis').click(function () {
      const id = $('#id_servis').val();
      const nama = $('#nama_servis').val();
      const harga = $('#harga_servis').val() || 0;
      if (!id) {
        Swal.fire({
          icon: 'warning',
          title: 'Pilih Servis',
          text: 'Silakan pilih jasa servis terlebih dahulu.'
        });
        return;
      }
      const row = `
      <tr data-id="${id}">
        <td>${nama}</td>
        <td class="text-right">${harga}</td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm btnHapusServis"><i class="fa fa-trash"></i></button>
        </td>
      </tr>`;
      $('#tabelServis tbody').append(row);
      hitungTotal();
      $('#id_servis').val('');
      $('#nama_servis').val('');
      $('#harga_servis').val('');
    });

    // === Hapus servis ===
    $(document).on('click', '.btnHapusServis', function () {
      $(this).closest('tr').remove();
      hitungTotal();
    });

    // === Sparepart subtotal ===
    // Saat jumlah berubah, hitung ulang subtotal
    $('#jumlah_sparepart').on('change keyup', function () {
      const hargaPerUnit = $('#subtotal_sparepart').data('harga-unit');
      if (hargaPerUnit) {
        const jumlah = parseInt($(this).val()) || 1;
        $('#subtotal_sparepart').val(hargaPerUnit * jumlah);
      }
    });

    // === Tambah sparepart ke tabel ===
    $('#btnTambahSparepart').click(function () {
      const id = $('#id_sparepart').val();
      const nama = $('#nama_sparepart').val();
      const subtotal = parseInt($('#subtotal_sparepart').val()) || 0;
      const jumlah = parseInt($('#jumlah_sparepart').val()) || 1;
      const harga = subtotal / jumlah;

      if (!id) {
        Swal.fire({
          icon: 'warning',
          title: 'Pilih Sparepart',
          text: 'Silakan pilih sparepart terlebih dahulu.'
        });
        return;
      }

      const row = `
      <tr data-id="${id}">
        <td>${nama}</td>
        <td class="text-center">${jumlah}</td>
        <td class="text-right">${harga}</td>
        <td class="text-right subtotal">${subtotal}</td>
        <td class="text-center">
          <button type="button" class="btn btn-danger btn-sm btnHapusSparepart"><i class="fa fa-trash"></i></button>
        </td>
      </tr>`;
      $('#tabelSparepart tbody').append(row);
      hitungTotal();

      $('#id_sparepart').val('');
      $('#nama_sparepart').val('');
      $('#jumlah_sparepart').val(1);
      $('#subtotal_sparepart').val('');
    });

    // === Hapus sparepart ===
    $(document).on('click', '.btnHapusSparepart', function () {
      $(this).closest('tr').remove();
      hitungTotal();
    });

    // === Hitung total semua ===
    function hitungTotal() {
      let total = 0;
      $('#tabelServis tbody tr').each(function () {
        total += parseFloat($(this).find('td:nth-child(2)').text()) || 0;
      });
      $('#tabelSparepart tbody tr').each(function () {
        total += parseFloat($(this).find('.subtotal').text()) || 0;
      });
      $('#total_biaya').val(total);
    }

  });
  // === Saat form disubmit, tambahkan data detail ke dalam form ===
  $('#formTransaksi').on('submit', function (e) {
    // Hapus input hidden sebelumnya (jika ada)
    $('input[name^="id_servis"]').remove();
    $('input[name^="harga_servis"]').remove();
    $('input[name^="id_sparepart"]').remove();
    $('input[name^="jumlah"]').remove();
    $('input[name^="harga"]').remove();
    $('input[name^="subtotal"]').remove();

    // --- Loop tabel servis ---
    $('#tabelServis tbody tr').each(function (i) {
      const idServis = $(this).data('id');
      const hargaServis = $(this).find('td:nth-child(2)').text();

      $('<input>').attr({
        type: 'hidden',
        name: 'id_servis[]',
        value: idServis
      }).appendTo('#formTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'harga_servis[]',
        value: hargaServis
      }).appendTo('#formTransaksi');
    });

    // --- Loop tabel sparepart ---
    $('#tabelSparepart tbody tr').each(function (i) {
      const idSparepart = $(this).data('id');
      const jumlah = $(this).find('td:nth-child(2)').text();
      const harga = $(this).find('td:nth-child(3)').text();
      const subtotal = $(this).find('td:nth-child(4)').text();

      $('<input>').attr({
        type: 'hidden',
        name: 'id_sparepart[]',
        value: idSparepart
      }).appendTo('#formTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'jumlah[]',
        value: jumlah
      }).appendTo('#formTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'harga[]',
        value: harga
      }).appendTo('#formTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'subtotal[]',
        value: subtotal
      }).appendTo('#formTransaksi');
    });

    // --- VALIDASI FRONTEND ---
    const idPelanggan = $('#id_pelanggan').val();
    if (!idPelanggan) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        text: 'Data pelanggan wajib diisi.'
      });
      return false;
    }

    const idMekanik = $('#id_mekanik').val();
    if (!idMekanik) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        text: 'Data mekanik wajib diisi.'
      });
      return false;
    }

    const adaServis = $('#tabelServis tbody tr').length > 0;
    if (!adaServis) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        text: 'Jasa servis wajib diisi minimal satu.'
      });
      return false;
    }
    // --- END VALIDASI FRONTEND ---
  });
  // modal cari data
  $(document).ready(function () {
    // === Tombol cari pelanggan ===
    $('#btnCariPelanggan').click(function () {
      $('#modalCariPelanggan').modal('show');
      loadPelanggan(); // tampilkan semua pelanggan yang punya pemesanan
    });
    // === Fitur pencarian pelanggan di modal ===
    $('#inputCariPelanggan').on('keyup', function () {
      const query = $(this).val();
      loadPelanggan(query);
    });
    // === Saat pilih pelanggan di tabel modal ===
    $(document).on('click', '.btnPilihPelanggan', function () {
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const hp = $(this).data('hp');
      const merk = $(this).data('merk');
      const tipe = $(this).data('tipe');
      const jenis = $(this).data('jenis');
      const warna = $(this).data('warna');
      const nopol = $(this).data('nopol');
      const keluhan = $(this).data('keluhan');

      $('#id_pelanggan').val(id);
      $('#nama_pelanggan').val(nama);
      $('#no_hp').val(hp);
      $('#merk_mobil').val(merk);
      $('#tipe_mobil').val(tipe);
      $('#warna_mobil').val(warna);
      $('#jenis_mobil').val(jenis);
      $('#no_polisi').val(nopol);
      $('#keluhan').val(keluhan);

      $('#modalCariPelanggan').modal('hide');
      getPemesananByPelanggan(id);
    });


    // === Ambil data pemesanan pelanggan (fungsi dipisahkan agar reusable) ===
    function getPemesananByPelanggan(idPelanggan) {
      $.ajax({
        url: "<?= site_url('TransaksiServis/getPemesananByPelanggan/') ?>" + idPelanggan,
        method: "GET",
        dataType: "json",
        success: function (response) {
          if (response.ada_pemesanan) {
            const data = response.data;
            $('#id_pemesanan').val(data.id_pemesanan);
            $('#tanggal_servis').val(data.tanggal_servis).prop('readonly', true);
            $('#merk_mobil').val(data.merk).prop('readonly', true);
            $('#tipe_mobil').val(data.tipe).prop('readonly', true);
            $('#warna_mobil').val(data.warna).prop('readonly', true);
            $('#jenis_mobil').val(data.jenis_mobil).prop('readonly', true);
            $('#no_polisi').val(data.no_polisi).prop('readonly', true);
            $('#keluhan').val(data.keluhan).prop('readonly', true);
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Gagal memuat data pemesanan.'
          });
        }
      });
    }

    // === Load data pelanggan yang sudah pernah melakukan pemesanan ===
    function loadPelanggan(query = '') {
      $.ajax({
        url: "<?= site_url('TransaksiServis/getPelangganDenganPemesanan') ?>",
        method: "GET",
        data: {
          q: query
        },
        dataType: "json",
        success: function (res) {
          let rows = '';
          if (res.length === 0) {
            rows = `<tr><td colspan="9" class="text-center text-muted">Tidak ada pelanggan dengan pemesanan</td></tr>`;
          } else {
            res.forEach(p => {
              rows += `
            <tr>
              <td>${p.kode_pemesanan}</td>
              <td>${p.nama_pelanggan}</td>
              <td>${p.no_hp}</td>
              <td>${p.merk ?? '-'}</td>
              <td>${p.tipe ?? '-'}</td>
              <td>${p.jenis_mobil ?? '-'}</td>
              <td>${p.warna ?? '-'}</td>
              <td>${p.no_polisi ?? '-'}</td>
              <td>${p.keluhan ?? '-'}</td>
              <td class="text-center">
                <button type="button" class="btn btn-success btn-sm btnPilihPelanggan"
                  data-id="${p.id_pelanggan}"
                  data-nama="${p.nama_pelanggan}"
                  data-hp="${p.no_hp}"
                  data-merk="${p.merk ?? ''}"
                  data-tipe="${p.tipe ?? ''}"
                  data-warna="${p.warna ?? ''}"
                  data-jenis="${p.jenis_mobil ?? ''}"
                  data-nopol="${p.no_polisi ?? ''}"
                  data-keluhan="${p.keluhan ?? ''}">
                  Pilih
                </button>
              </td>
            </tr>`;
            });
          }
          $('#tabelCariPelanggan tbody').html(rows);
        },
        error: function () {
          $('#tabelCariPelanggan tbody').html(
            `<tr><td colspan="6" class="text-center text-danger">Gagal memuat data pelanggan</td></tr>`
          );
        }
      });
    }

    $(document).on('hidden.bs.modal', '.modal', function () {
      if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open'); // jaga agar scroll tetap bisa di modal utama
      }
    });
  });
</script>
<style>
  #modalformtambah .modal-body {
    max-height: 65vh;
    overflow-y: auto;
  }

  .table-scroll {
    max-height: 420px;
    /* ± 10 baris */
    overflow-y: auto;
  }

  .table-scroll thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 2;
  }
</style>