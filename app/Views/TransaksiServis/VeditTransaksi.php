<!-- Modal Edit Transaksi Servis -->
<div class="modal fade" id="modalformedit" tabindex="-1" aria-labelledby="modalEditTransaksiLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalEditTransaksiLabel">Edit Transaksi Servis</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <!-- Body -->
      <form id="formEditTransaksi" action="<?= base_url('TransaksiServis/update'); ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id_transaksi" id="id_transaksi" value="<?= esc($transaksi['id_transaksi']) ?>">
        <input type="hidden" name="id_pemesanan" id="id_pemesanan" value="<?= esc($transaksi['id_pemesanan']) ?>">
        
        <div class="modal-body">
          <!-- Baris 1 -->
          <div class="form-row mb-3">
            <div class="col-md-4">
              <label>Nama Pelanggan</label>
              <div class="input-group">
                <input type="text" class="form-control" id="nama_pelanggan" readonly
                  value="<?= esc($transaksi['nama_pelanggan']) ?>" required>
                <div class="input-group-append">
                  <!-- Dimatikan pencariannya karena edit transaksi biasanya hanya edit detailnya -->
                  <button type="button" class="btn btn-secondary" disabled><i class="fa fa-search"></i></button>
                </div>
              </div>
              <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?= esc($transaksi['id_pelanggan']) ?>">
            </div>
            <div class="col-md-4">
              <label>No HP</label>
              <input type="text" class="form-control" id="no_hp" name="no_hp" readonly value="<?= esc($transaksi['no_hp']) ?>">
            </div>
            <div class="col-md-4">
              <label>Tanggal Servis</label>
              <input type="date" class="form-control" name="tanggal_servis" id="tanggal_servis" required value="<?= esc($transaksi['tanggal_servis']) ?>">
            </div>
          </div>
          <!-- Baris 2 -->
          <div class="form-row mb-3">
            <div class="col-md-4">
              <label>No Polisi</label>
              <input type="text" class="form-control" id="no_polisi" name="no_polisi" readonly value="<?= esc($transaksi['no_polisi']) ?>">
            </div>
            <div class="col-md-4">
              <label>Merk</label>
              <input type="text" class="form-control" id="merk_mobil" name="merk_mobil" readonly value="<?= esc($transaksi['merk_mobil']) ?>">
            </div>
            <div class="col-md-2">
              <label>Tipe</label>
              <input type="text" class="form-control" id="tipe_mobil" name="tipe_mobil" readonly value="<?= esc($transaksi['tipe']) ?>">
            </div>
            <div class="col-md-2">
              <label>Warna</label>
              <input type="text" class="form-control" id="warna_mobil" name="warna_mobil" readonly value="<?= esc($transaksi['warna']) ?>">
            </div>
          </div>
          <!-- Baris 3 -->
          <div class="form-row mb-3">
            <div class="col-md-3">
              <label>Jenis</label>
              <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" readonly value="<?= esc($transaksi['jenis_mobil']) ?>">
            </div>
            <div class="col-md-5">
              <label>Keluhan</label>
              <input type="text" class="form-control" id="keluhan" name="keluhan" readonly value="<?= esc($transaksi['keluhan']) ?>">
            </div>
            <div class="col-md-4">
              <label>Mekanik</label>
              <div class="input-group">
                <input type="text" class="form-control" id="nama_mekanik" readonly
                  value="<?= esc($transaksi['nama_mekanik']) ?>" required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" id="btnCariMekanikEdit"><i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <input type="hidden" id="id_mekanik" name="id_mekanik" value="<?= esc($transaksi['id_mekanik']) ?>">
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
                      <button type="button" class="btn btn-primary" id="btnCariServisEdit"><i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <label>Harga Jasa</label>
                  <input type="text" class="form-control" id="harga_servis" readonly>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-success btn-block" id="btnTambahServisEdit">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <table class="table table-bordered table-sm" id="tabelServisEdit">
                <thead class="thead-light text-center">
                  <tr>
                    <th>Nama Servis</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php if(!empty($servisDetail)): ?>
                        <?php foreach($servisDetail as $sd): ?>
                        <tr data-id="<?= esc($sd['id_servis']) ?>">
                            <td><?= esc($sd['nama_servis']) ?></td>
                            <td class="text-right"><?= esc($sd['harga_js']) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btnHapusServisEdit"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
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
                      <button type="button" class="btn btn-primary" id="btnCariSparepartEdit"><i class="fa fa-search"></i>
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
                  <button type="button" class="btn btn-success btn-block" id="btnTambahSparepartEdit">
                    <i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>
              <table class="table table-bordered table-sm" id="tabelSparepartEdit">
                <thead class="thead-light text-center">
                  <tr>
                    <th>Nama Sparepart</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php if(!empty($sparepartDetail)): ?>
                        <?php foreach($sparepartDetail as $sp): ?>
                        <tr data-id="<?= esc($sp['id_sparepart']) ?>">
                            <td><?= esc($sp['nama_sparepart']) ?></td>
                            <td class="text-center"><?= esc($sp['jumlah_sp']) ?></td>
                            <td class="text-right"><?= esc($sp['harga_sp']) ?></td>
                            <td class="text-right subtotal"><?= esc($sp['jumlah_sp'] * $sp['harga_sp']) ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btnHapusSparepartEdit"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group mt-3 text-right">
            <label><strong>Total Biaya:</strong></label>
            <input type="text" id="total_biaya_edit" name="total_biaya" class="form-control text-right font-weight-bold"
              readonly value="<?= esc($transaksi['total_biaya']) ?>">
          </div>
        </div> <!-- /modal-body -->
        <!-- Footer tombol -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i> Batal
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Update Transaksi
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Cari Mekanik -->
<div class="modal fade" id="modalCariMekanikEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Mekanik</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariMekanikEdit" class="form-control mb-2" placeholder="Cari nama mekanik...">
        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariMekanikEdit">
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

<!-- Modal Cari Servis -->
<div class="modal fade" id="modalCariServisEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Jasa Servis</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariServisEdit" class="form-control mb-2" placeholder="Cari jasa servis...">
        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariServisEdit">
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

<!-- Modal Cari Sparepart -->
<div class="modal fade" id="modalCariSparepartEdit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Cari Sparepart</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" id="inputCariSparepartEdit" class="form-control mb-2" placeholder="Cari sparepart...">
        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0" id="tabelCariSparepartEdit">
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

<script>
  $(document).ready(function () {
    // === MODAL CARI MEKANIK ===
    $('#btnCariMekanikEdit').click(function () {
      $('#modalCariMekanikEdit').modal('show');
      loadMekanikEdit();
    });

    $('#inputCariMekanikEdit').on('keyup', function () {
      const query = $(this).val();
      loadMekanikEdit(query);
    });

    $(document).on('click', '.btnPilihMekanikEdit', function () {
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      $('#id_mekanik').val(id);
      $('#nama_mekanik').val(nama);
      $('#modalCariMekanikEdit').modal('hide');
    });

    function loadMekanikEdit(query = '') {
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
                          <button type="button" class="btn btn-success btn-sm btnPilihMekanikEdit"
                            data-id="${m.id_mekanik}"
                            data-nama="${m.nama_mekanik}">
                            Pilih
                          </button>
                        </td>
                      </tr>`;
            });
          }
          $('#tabelCariMekanikEdit tbody').html(rows);
        },
        error: function () {
          $('#tabelCariMekanikEdit tbody').html(
            `<tr><td colspan="3" class="text-center text-danger">Gagal memuat data mekanik</td></tr>`
          );
        }
      });
    }

    // === MODAL CARI SERVIS ===
    $('#btnCariServisEdit').click(function () {
      $('#modalCariServisEdit').modal('show');
      loadServisEdit();
    });

    $('#inputCariServisEdit').on('keyup', function () {
      const query = $(this).val();
      loadServisEdit(query);
    });

    $(document).on('click', '.btnPilihServisEdit', function () {
      const id = $(this).data('id');
      const nama = $(this).data('nama');
      const harga = $(this).data('harga');
      $('#id_servis').val(id);
      $('#nama_servis').val(nama);
      $('#harga_servis').val(harga);
      $('#modalCariServisEdit').modal('hide');
    });

    function loadServisEdit(query = '') {
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
                          <button type="button" class="btn btn-success btn-sm btnPilihServisEdit"
                            data-id="${s.id_servis}"
                            data-nama="${s.nama_servis}"
                            data-harga="${s.harga_servis}">
                            Pilih
                          </button>
                        </td>
                      </tr>`;
            });
          }
          $('#tabelCariServisEdit tbody').html(rows);
        },
        error: function () {
          $('#tabelCariServisEdit tbody').html(
            `<tr><td colspan="3" class="text-center text-danger">Gagal memuat data servis</td></tr>`
          );
        }
      });
    }

    // === MODAL CARI SPAREPART ===
    $('#btnCariSparepartEdit').click(function () {
      $('#modalCariSparepartEdit').modal('show');
      loadSparepartEdit();
    });

    $('#inputCariSparepartEdit').on('keyup', function () {
      const query = $(this).val();
      loadSparepartEdit(query);
    });

    $(document).on('click', '.btnPilihSparepartEdit', function () {
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
      $('#modalCariSparepartEdit').modal('hide');
    });

    function loadSparepartEdit(query = '') {
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
                          <button type="button" class="btn btn-success btn-sm btnPilihSparepartEdit"
                            data-id="${sp.id_sparepart}"
                            data-nama="${sp.nama_sparepart}"
                            data-harga="${sp.harga_jual}">
                            Pilih
                          </button>
                        </td>
                      </tr>`;
            });
          }
          $('#tabelCariSparepartEdit tbody').html(rows);
        },
        error: function () {
          $('#tabelCariSparepartEdit tbody').html(
            `<tr><td colspan="4" class="text-center text-danger">Gagal memuat data sparepart</td></tr>`
          );
        }
      });
    }

    // === Tambah servis ke tabel ===
    $('#btnTambahServisEdit').click(function () {
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
          <button type="button" class="btn btn-danger btn-sm btnHapusServisEdit"><i class="fa fa-trash"></i></button>
        </td>
      </tr>`;
      $('#tabelServisEdit tbody').append(row);
      hitungTotalEdit();
      $('#id_servis').val('');
      $('#nama_servis').val('');
      $('#harga_servis').val('');
    });

    // === Hapus servis ===
    $(document).on('click', '.btnHapusServisEdit', function () {
      $(this).closest('tr').remove();
      hitungTotalEdit();
    });

    // === Sparepart subtotal ===
    $('#jumlah_sparepart').on('change keyup', function () {
      const hargaPerUnit = $('#subtotal_sparepart').data('harga-unit');
      if (hargaPerUnit) {
        const jumlah = parseInt($(this).val()) || 1;
        $('#subtotal_sparepart').val(hargaPerUnit * jumlah);
      }
    });

    // === Tambah sparepart ke tabel ===
    $('#btnTambahSparepartEdit').click(function () {
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
          <button type="button" class="btn btn-danger btn-sm btnHapusSparepartEdit"><i class="fa fa-trash"></i></button>
        </td>
      </tr>`;
      $('#tabelSparepartEdit tbody').append(row);
      hitungTotalEdit();

      $('#id_sparepart').val('');
      $('#nama_sparepart').val('');
      $('#jumlah_sparepart').val(1);
      $('#subtotal_sparepart').val('');
    });

    // === Hapus sparepart ===
    $(document).on('click', '.btnHapusSparepartEdit', function () {
      $(this).closest('tr').remove();
      hitungTotalEdit();
    });

    // === Hitung total semua ===
    function hitungTotalEdit() {
      let total = 0;
      $('#tabelServisEdit tbody tr').each(function () {
        total += parseFloat($(this).find('td:nth-child(2)').text()) || 0;
      });
      $('#tabelSparepartEdit tbody tr').each(function () {
        total += parseFloat($(this).find('.subtotal').text()) || 0;
      });
      $('#total_biaya_edit').val(total);
    }

  });
  
  // === Saat form disubmit, tambahkan data detail ke dalam form ===
  $('#formEditTransaksi').on('submit', function (e) {
    // Hapus input hidden sebelumnya (jika ada)
    $('input[name^="id_servis"]').remove();
    $('input[name^="harga_servis"]').remove();
    $('input[name^="id_sparepart"]').remove();
    $('input[name^="jumlah"]').remove();
    $('input[name^="harga"]').remove();
    $('input[name^="subtotal"]').remove();

    // --- Loop tabel servis ---
    $('#tabelServisEdit tbody tr').each(function (i) {
      const idServis = $(this).data('id');
      const hargaServis = $(this).find('td:nth-child(2)').text();

      $('<input>').attr({
        type: 'hidden',
        name: 'id_servis[]',
        value: idServis
      }).appendTo('#formEditTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'harga_servis[]',
        value: hargaServis
      }).appendTo('#formEditTransaksi');
    });

    // --- Loop tabel sparepart ---
    $('#tabelSparepartEdit tbody tr').each(function (i) {
      const idSparepart = $(this).data('id');
      const jumlah = $(this).find('td:nth-child(2)').text();
      const harga = $(this).find('td:nth-child(3)').text();
      const subtotal = $(this).find('td:nth-child(4)').text();

      $('<input>').attr({
        type: 'hidden',
        name: 'id_sparepart[]',
        value: idSparepart
      }).appendTo('#formEditTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'jumlah[]',
        value: jumlah
      }).appendTo('#formEditTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'harga[]',
        value: harga
      }).appendTo('#formEditTransaksi');

      $('<input>').attr({
        type: 'hidden',
        name: 'subtotal[]',
        value: subtotal
      }).appendTo('#formEditTransaksi');
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

    const adaServis = $('#tabelServisEdit tbody tr').length > 0;
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

  $(document).on('hidden.bs.modal', '.modal', function () {
    if ($('.modal.show').length > 0) {
      $('body').addClass('modal-open'); // jaga agar scroll tetap bisa di modal utama
    }
  });
</script>

<style>
  #modalformedit .modal-body {
    max-height: 65vh;
    overflow-y: auto;
  }

  .table-scroll {
    max-height: 400px;
    overflow-y: auto;
  }
</style>
