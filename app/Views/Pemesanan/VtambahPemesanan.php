<!-- Modal -->
<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalformtambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformtambahLabel">
                    <i class="fa fa-calendar-plus-o"></i> Tambah Data Pemesanan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formPemesanan">
                    <?= csrf_field() ?>

                    <?php if (session()->get('level') == 'admin') : ?>
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <div class="input-group">
                                <input type="hidden" name="id_pelanggan" id="id_pelanggan" required>

                                <input type="text" id="nama_pelanggan" class="form-control"
                                    placeholder="Pilih pelanggan..." readonly required>

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalPelanggan">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="id_pelanggan" value="<?= session()->get('id_pelanggan') ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="tanggal_servis">Tanggal Servis</label>
                        <input type="date" name="tanggal_servis" id="tanggal_servis" class="form-control" min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="jam_servis">Jam Servis</label>
                        <input type="time" name="jam_servis" id="jam_servis" class="form-control" required>
                    </div>

                    <div class="form-group" id="wrapperMobil" style="display:none">
                        <label for="id_mobil">Pilih Mobil</label>
                        <select name="id_mobil" id="id_mobil" class="form-control" required>
                            <option value="">-- Pilih Mobil --</option>
                        </select>
                        <small class="text-muted">Pilih pelanggan terlebih dahulu untuk menampilkan daftar mobil.</small>
                    </div>

                    <!-- Form Input Mobil Baru -->
                    <div id="formMobilBaru" style="display:none; border: 1px solid #ced4da; padding: 15px; border-radius: 5px; margin-bottom: 15px; background-color: #f9f9f9;">
                        <h6 class="text-primary font-weight-bold mb-3"><i class="fa fa-car"></i> Tambah Mobil Baru</h6>
                        <div class="form-group">
                            <label for="no_polisi">No Polisi (Plat Nomor) <span class="text-danger">*</span></label>
                            <input type="text" name="no_polisi" id="no_polisi" class="form-control" placeholder="Contoh: BA 1234 XY">
                        </div>
                        <div class="form-group">
                            <label for="merk">Merk Kendaraan <span class="text-danger">*</span></label>
                            <select name="merk" id="merk" class="form-control">
                                <option value="">-- Pilih Merk --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe Kendaraan <span class="text-danger">*</span></label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="">-- Pilih Tipe --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" name="jenis" id="jenis" class="form-control bg-light" readonly placeholder="Jenis akan terisi otomatis">
                        </div>
                        <div class="form-group">
                            <label for="warna">Warna <span class="text-danger">*</span></label>
                            <input type="text" name="warna" id="warna" class="form-control" placeholder="Contoh: Hitam">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keluhan">Keluhan</label>
                        <textarea name="keluhan" id="keluhan" class="form-control" rows="2" placeholder="Tuliskan keluhan kendaraan" required></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnsimpan">
                    <i class="fa fa-save"></i> Pesan
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pelanggan -->
<div class="modal fade" id="modalPelanggan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="fa fa-users"></i> Pilih Pelanggan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="text"
                    id="cariPelanggan"
                    class="form-control mb-2"
                    placeholder="Cari nama pelanggan atau no HP...">

                <div class="table-responsive table-scroll">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Pelanggan</th>
                                <th>No HP</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelPelanggan">
                            <?php $no = 1;
                            foreach ($pelanggan as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $p['nama_pelanggan'] ?></td>
                                    <td><?= $p['no_hp'] ?></td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm btn-success pilihPelanggan"
                                            data-id="<?= $p['id_pelanggan'] ?>"
                                            data-nama="<?= $p['nama_pelanggan'] ?>">
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
</div>
<script>
    const dataMobil = {
        "Toyota": {
            "Avanza": "Minibus", "Innova": "Minibus", "Alphard": "Minibus", "Rush": "SUV", "Fortuner": "SUV", "Yaris": "Hatchback", "Agya": "Hatchback", "Calya": "Minibus", "Vios": "Sedan", "Camry": "Sedan", "Hilux": "Pick Up"
        },
        "Honda": {
            "Brio": "Hatchback", "Jazz": "Hatchback", "HR-V": "SUV", "CR-V": "SUV", "BR-V": "SUV", "Mobilio": "Minibus", "Civic": "Sedan", "City": "Sedan", "Accord": "Sedan"
        },
        "Daihatsu": {
            "Xenia": "Minibus", "Terios": "SUV", "Ayla": "Hatchback", "Sigra": "Minibus", "Sirion": "Hatchback", "Rocky": "SUV", "Gran Max": "Pick Up", "Luxio": "Minibus"
        },
        "Suzuki": {
            "Ertiga": "Minibus", "XL7": "SUV", "Ignis": "Hatchback", "Baleno": "Hatchback", "Carry": "Pick Up", "APV": "Minibus"
        },
        "Mitsubishi": {
            "Xpander": "Minibus", "Xpander Cross": "SUV", "Pajero Sport": "SUV", "Outlander": "SUV", "Mirage": "Hatchback", "L300": "Pick Up", "Triton": "Pick Up"
        },
        "Nissan": {
            "Livina": "Minibus", "X-Trail": "SUV", "Kicks": "SUV", "Magnite": "SUV", "Serena": "Minibus", "March": "Hatchback"
        },
        "Lainnya": {
            "Lainnya": "Lainnya"
        }
    };

    $(document).ready(function() {
        // Populate Merk
        $.each(dataMobil, function(merk, types) {
            $('#merk').append(new Option(merk, merk));
        });

        // On Merk Change
        $('#merk').change(function() {
            let selectedMerk = $(this).val();
            let tipeSelect = $('#tipe');
            let jenisInput = $('#jenis');
            
            tipeSelect.empty().append(new Option("-- Pilih Tipe --", ""));
            jenisInput.val('');
            
            if (selectedMerk && dataMobil[selectedMerk]) {
                $.each(dataMobil[selectedMerk], function(tipe, jenis) {
                    tipeSelect.append(new Option(tipe, tipe));
                });
            }
        });

        // On Tipe Change
        $('#tipe').change(function() {
            let selectedMerk = $('#merk').val();
            let selectedTipe = $(this).val();
            
            if (selectedMerk && selectedTipe && dataMobil[selectedMerk][selectedTipe]) {
                $('#jenis').val(dataMobil[selectedMerk][selectedTipe]);
            } else {
                $('#jenis').val('');
            }
        });
    });

    $('#cariPelanggan').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#tabelPelanggan tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $(document).on('click', '.pilihPelanggan', function() {
        let id = $(this).data('id');
        let nama = $(this).data('nama');

        $('#id_pelanggan').val(id);
        $('#nama_pelanggan').val(nama);

        // Hide mobil baru form in case it was open
        $('#formMobilBaru').hide();
        $('#no_polisi').removeAttr('required').val('');
        $('#merk').val('');
        $('#tipe').val('');
        $('#jenis').removeAttr('required').val('');
        $('#warna').removeAttr('required').val('');

        // Load mobil milik pelanggan ini
        $('#id_mobil').html('<option value="">Memuat...</option>');
        $.get('<?= site_url("Pemesanan/getMobilPelanggan") ?>', { id_pelanggan: id }, function(data) {
            let opts = '<option value="">-- Pilih Mobil --</option>';
            if (data.length > 0) {
                data.forEach(function(m) {
                    opts += `<option value="${m.id_mobil}">${m.no_polisi} - ${m.merk} ${m.tipe} (${m.jenis})</option>`;
                });
            }
            opts += '<option value="baru">+ Tambah Mobil Baru</option>';
            $('#id_mobil').html(opts);
            $('#wrapperMobil').show();
        });

        $('#modalPelanggan').modal('hide');
    });

    $(document).on('change', '#id_mobil', function() {
        if ($(this).val() === 'baru') {
            $('#formMobilBaru').slideDown();
            $('#no_polisi').attr('required', true);
            $('#jenis').attr('required', true);
            $('#warna').attr('required', true);
        } else {
            $('#formMobilBaru').slideUp();
            $('#no_polisi').removeAttr('required').val('');
            $('#merk').val('');
            $('#tipe').val('');
            $('#jenis').removeAttr('required').val('');
            $('#warna').removeAttr('required').val('');
        }
    });

    $('#btnsimpan').click(function() {
        $.ajax({
            type: "POST",
            url: "<?= site_url('Pemesanan/simpan') ?>",
            data: $('#formPemesanan').serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#btnsimpan').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
            },
            success: function(response) {
                $('#btnsimpan').attr('disabled', false).html('<i class="fa fa-save"></i> Pesan');

                if (response.success) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: response.message,
                        icon: 'success'
                    }).then(() => {
                        $('#modalformtambah').modal('hide');
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
                $('#btnsimpan').attr('disabled', false).html('<i class="fa fa-save"></i> Pesan');
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan pada server: ' + xhr.status,
                    icon: 'error'
                });
                console.error(xhr.responseText);
            }
        });
    });

    // Validasi Hari Jumat
    $('#tanggal_servis').on('change', function() {
        let dateVal = $(this).val();
        if (dateVal) {
            let date = new Date(dateVal);
            if (date.getDay() === 5) { // 5 adalah hari Jumat
                Swal.fire({
                    icon: 'warning',
                    title: 'Hari Libur',
                    text: 'Maaf, hari Jumat bengkel kami libur. Silakan pilih hari lain.'
                });
                $(this).val('');
            }
        }
    });


</script>

<style>
    #modalformtambah .modal-body {
        max-height: 65vh;
        overflow-y: auto;
    }

    .modal-header {
        border-bottom: 2px solid #007bff;
    }

    .modal-title {
        font-weight: bold;
    }

    .form-group label {
        font-weight: 600;
    }

    .btn-primary i,
    .btn-secondary i {
        margin-right: 4px;
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
        z-index: 1;
    }
</style>