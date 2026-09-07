<div class="modal fade" id="modalFormTambah" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="judulModal">Form Pembayaran</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

        <form id="formTambahPembayaran">
          <?= csrf_field() ?>

          <!-- Baris 1: ID Transaksi, Tgl Servis, Tgl Diambil -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label>ID Transaksi</label>
              <div class="input-group">
                <input type="hidden" name="id_transaksi" id="id_transaksi" required>

                <input type="text" id="label_transaksi" class="form-control" placeholder="Pilih transaksi..." readonly>

                <div class="input-group-append">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalCariTransaksi">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>

            </div>
            <div class="form-group col-md-4">
              <label>Tanggal Servis</label>
              <input type="date" name="tanggal_servis" id="tanggal_servis" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Tanggal Diambil</label>
              <input type="date" name="tanggal_diambil" id="tanggal_diambil" class="form-control">
            </div>
          </div>

          <!-- Baris 2: Nama Pelanggan, No HP, Mekanik -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Nama Pelanggan</label>
              <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>No HP</label>
              <input type="text" name="no_hp" id="no_hp" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Mekanik</label>
              <input type="text" name="nama_mekanik" id="nama_mekanik" class="form-control" readonly>
            </div>
          </div>

          <!-- Baris 3: Jenis Mobil, No Polisi, Keluhan -->
          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Tipe</label>
              <input type="text" name="tipe" id="tipe" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>No Polisi</label>
              <input type="text" name="no_polisi" id="no_polisi" class="form-control" readonly>
            </div>
            <div class="form-group col-md-4">
              <label>Keluhan</label>
              <input type="text" name="keluhan" id="keluhan" class="form-control" readonly>
            </div>
          </div>

          <!-- Tabel Servis & Sparepart -->
          <div class="table-responsive mt-3">
            <table class="table table-bordered" id="tabelDetailServis">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Jenis Servis</th>
                  <th>Harga Jasa</th>
                  <th>Sparepart</th>
                  <th>Harga Sparepart</th>

                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="6" class="text-center text-muted">Data servis akan tampil setelah memilih transaksi</td>
                </tr>
              </tbody>
            </table>

          </div>

          <!-- Baris Akhir: Diskon, Total Bayar, Dibayar, Kembalian -->
          <div class="form-row mt-3">
            <div class="form-group col-md-3">
              <label>Diskon (Rp)</label>
              <input type="number" name="diskon" id="diskon" class="form-control" value="0">
            </div>
            <div class="form-group col-md-3">
              <label>Total Bayar (Rp)</label>
              <input type="number" name="total_bayar" id="total_bayar" class="form-control" readonly>
            </div>
            <div class="form-group col-md-3">
              <label>Dibayar (Rp)</label>
              <input type="number" name="dibayar" id="dibayar" class="form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Kembalian (Rp)</label>
              <input type="number" name="kembalian" id="kembalian" class="form-control" readonly>
            </div>
          </div>

          <!-- Tombol -->
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
</div>
<!-- Modal Cari Transaksi -->
<div class="modal fade" id="modalCariTransaksi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">
          <i class="fa fa-search"></i> Pilih Transaksi
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <!-- input cari -->
        <input type="text" id="cariTransaksi" class="form-control mb-2" placeholder="Cari ID / nama pelanggan...">

        <div class="table-responsive table-scroll">
          <table class="table table-bordered table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th>Kode Booking</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th width="10%">Aksi</th>
              </tr>
            </thead>
            <tbody id="tabelTransaksi">
              <?php foreach ($transaksi as $t): ?>
                <tr>
                  <td><?= $t['id_transaksi'] ?> - <?= $t['kode_pemesanan'] ?></td>
                  <td><?= esc($t['nama_pelanggan']) ?></td>
                  <td><?= $t['tanggal_servis'] ?></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-success pilihTransaksi"
                      data-id="<?= $t['id_transaksi'] ?>"
                      data-label="<?= $t['id_transaksi'] . ' - ' . $t['kode_pemesanan'] ?>">
                      Pilih
                    </button>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // pilih transaksi
  $(document).on('click', '.pilihTransaksi', function () {
    $('#id_transaksi').val($(this).data('id')).trigger('change');
    $('#label_transaksi').val($(this).data('label'));
    $('#modalCariTransaksi').modal('hide');
  });

  // cari transaksi
  $('#cariTransaksi').on('keyup', function () {
    let val = $(this).val().toLowerCase();
    $('#tabelTransaksi tr').filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });
</script>

<script>
  $('#formTambahPembayaran').on('submit', function (e) {
    e.preventDefault(); // cegah form submit default

    // debug, cek data yang dikirim
    console.log($(this).serialize());

    $.ajax({
      type: "POST",
      url: "<?= site_url('Pembayaran/simpan') ?>",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        console.log('Response:', response);

        if (response.sukses) {
          Swal.fire({
            title: 'Berhasil',
            text: response.sukses,
            icon: 'success'
          }).then(() => {
            $('#modalFormTambah').modal('hide'); // tutup modal
            window.location.reload(); // reload halaman agar data terbaru tampil
          });
        } else if (response.error) {
          // jika error array atau string
          let pesan = Array.isArray(response.error) ? response.error.join('\n') : response.error;
          Swal.fire({
            title: 'Gagal',
            text: pesan || 'Terjadi kesalahan.',
            icon: 'error'
          });
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        console.error('Error:', xhr.status, xhr.responseText, thrownError);

        Swal.fire({
          title: 'Error',
          text: 'Terjadi kesalahan pada server: ' + xhr.status + '\n' + xhr.responseText,
          icon: 'error'
        });
      }
    });
  });


  $(function () {
    // pastikan ada hidden field untuk menyimpan grand total sebelum diskon
    if ($('#total_before_diskon').length === 0) {
      $('<input>').attr({
        type: 'hidden',
        id: 'total_before_diskon',
        name: 'total_before_diskon',
        value: 0
      }).appendTo('#formTambahPembayaran'); // atau form selector lain
    }

    // fungsi bantu parse number aman
    function toNum(v) {
      if (v === null || v === undefined) return 0;
      // hapus non-digit (jika ada formatting) lalu parse
      v = String(v).replace(/[^0-9\.\-]/g, '');
      var n = parseFloat(v);
      return isNaN(n) ? 0 : n;
    }

    // fungsi recalc kembalian & total setelah diskon
    function recalcPayment() {
      var totalBefore = toNum($('#total_before_diskon').val());
      var diskon = toNum($('#diskon').val());
      var dibayar = toNum($('#dibayar').val());

      // batasan
      if (diskon < 0) diskon = 0;
      if (diskon > totalBefore) diskon = totalBefore;

      var totalAfterDiscount = totalBefore - diskon;
      if (totalAfterDiscount < 0) totalAfterDiscount = 0;

      var kembalian = dibayar - totalAfterDiscount;

      // tampilkan (tanpa pemformatan ribuan supaya mudah dipakai submit)
      $('#total_bayar').val(Math.round(totalAfterDiscount));
      $('#kembalian').val(Math.round(kembalian));
    }

    // ketika memilih transaksi => ambil data & detail (tetap gunakan ajax Anda)
    $('#id_transaksi').on('change', function () {
      var idTransaksi = $(this).val();
      if (!idTransaksi) {
        // reset tampilan
        $('#tabelDetailServis tbody').html('<tr><td colspan="6" class="text-center text-muted">Data servis akan tampil setelah memilih transaksi</td></tr>');
        $('#total_before_diskon').val(0);
        $('#total_bayar').val(0);
        $('#diskon').val(0);
        $('#dibayar').val('');
        $('#kembalian').val('');
        return;
      }

      // Ambil data utama transaksi
      $.ajax({
        url: '/Pembayaran/getTransaksiData/' + idTransaksi,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          if (data) {
            $('#tanggal_servis').val(data.tanggal_servis);
            $('#nama_pelanggan').val(data.nama_pelanggan);
            $('#no_hp').val(data.no_hp);
            $('#nama_mekanik').val(data.nama_mekanik);
            $('#tipe').val(data.tipe);
            $('#no_polisi').val(data.no_polisi);
            $('#keluhan').val(data.keluhan || data.keluhan_pesan);
            // jangan set total_bayar di sini — kita set dari grandTotal (detail)
          }
        },
        error: function (xhr) {
          console.error('Error getTransaksiData:', xhr.responseText);
        }
      });

      // Ambil detail servis dan hitung grandTotal
      $.ajax({
        url: '/Pembayaran/getDetailServis/' + idTransaksi,
        type: 'GET',
        dataType: 'json',
        success: function (details) {
          var tbody = '';
          var grandTotal = 0;

          if (details && details.length > 0) {
            $.each(details, function (i, item) {
              var hargaServis = toNum(item.harga_servis);
              var hargaSpare = toNum(item.harga_jual);
              var jumlah = toNum(item.jumlah) || 1; // default 1 jika tidak ada
              var subtotalServis = hargaServis;
              var subtotalSpare = hargaSpare * jumlah;
              var subtotal = subtotalServis + subtotalSpare;

              grandTotal += subtotal;

              tbody += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + (item.nama_servis ? item.nama_servis : '-') + '</td>' +
                '<td class="text-right">' + (isNaN(hargaServis) ? '-' : hargaServis) + '</td>' +
                '<td>' + (item.nama_sparepart ? item.nama_sparepart : '-') + '</td>' +
                '<td class="text-right">' + (isNaN(hargaSpare) ? '-' : hargaSpare) + '</td>' +
                // '<td class="text-center">' + jumlah + '</td>' +
                '<td class="text-right">' + Math.round(subtotal) + '</td>' +
                '</tr>';

            });
          } else {
            tbody = '<tr><td colspan="6" class="text-center text-muted">Tidak ada data servis</td></tr>';
          }

          $('#tabelDetailServis tbody').html(tbody);

          // simpan grandTotal di hidden dan set total_bayar awal
          $('#total_before_diskon').val(Math.round(grandTotal));

          // reset diskon/dibayar/kembalian supaya konsisten
          // (jika mau mempertahankan nilai diskon sebelumnya, hapus baris berikut)
          $('#diskon').val(0);
          $('#dibayar').val('');
          $('#kembalian').val('');

          // hitung akhir
          recalcPayment();
        },
        error: function (xhr) {
          console.error('Error getDetailServis:', xhr.responseText);
          $('#tabelDetailServis tbody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat detail servis</td></tr>');
        }
      });
    });

    // recalculates when user change diskon or dibayar
    $(document).on('input', '#diskon, #dibayar', function () {
      recalcPayment();
    });

    // inisialisasi awal
    recalcPayment();
  });
</script>
<style>
  .table-scroll {
    max-height: 420px;
    /* ± 10 baris */
    overflow-y: auto;
  }

  .table-scroll thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 1;
  }
</style>