<div class="modal fade" id="modalformtambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penjualan Sparepart</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Penjualansparepart/simpan', ['class' => 'formsimpan']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kode Penjualan</label>
                            <input type="text" name="kode_penjualan" class="form-control" value="<?= $kode_penjualan ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Penjualan</label>
                            <input type="date" name="tanggal_penjualan" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pelanggan</label>
                            <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                            <div class="input-group">
                                <input type="text" id="nama_pelanggan" class="form-control" placeholder="Pilih Pelanggan..." readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPelanggan">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Daftar Item Sparepart</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="tabelItem">
                        <thead class="bg-light text-center">
                            <tr>
                                <th>Sparepart</th>
                                <th>Harga Jual (Rp)</th>
                                <th width="10%">Jumlah</th>
                                <th>Stok</th>
                                <th width="15%">Subtotal (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemRows">
                            <!-- Rows added dynamically -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm" onclick="addRow()">
                                        <i class="fa fa-plus"></i> Tambah Baris
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="form-group">
                    <label>Total Penjualan (Rp)</label>
                    <input type="text" name="total_penjualan" id="total_penjualan" class="form-control text-right font-weight-bold" value="0" readonly style="font-size: 1.2rem;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Batal</button>
                <button type="submit" class="btn btn-primary btn-simpan"><i class="fa fa-save"></i> Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPelanggan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Pilih Pelanggan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="cariPelanggan" class="form-control" placeholder="Cari nama pelanggan...">
                </div>
                <div style="max-height:400px; overflow-y:auto;">
                    <table class="table table-bordered table-hover" id="tabelPelanggan">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Pelanggan</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pelanggan as $p) : ?>
                                <tr>
                                    <td><?= esc($p['nama_pelanggan']) ?></td>
                                    <td><?= esc($p['alamat'] ?? '-') ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm pilihPelanggan"
                                            data-id="<?= $p['id_pelanggan'] ?>"
                                            data-nama="<?= esc($p['nama_pelanggan']) ?>">
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
<div class="modal fade" id="modalSparepart">
    <div class="modal-dialog modal-gl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Pilih Sparepart</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <!-- INPUT CARI -->
                <div class="mb-3">
                    <input type="text" id="cariSparepart" class="form-control"
                        placeholder="Cari nama sparepart...">
                </div>

                <div style="max-height:400px; overflow-y:auto;">
                    <table class="table table-striped table-hover" id="tabelSparepart">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Sparepart</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sparepart as $s): ?>
                                <tr>
                                    <td><?= esc($s['nama_sparepart']) ?></td>
                                    <td><?= esc($s['stok']) ?></td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-success btn-sm pilihSparepart"
                                            data-id="<?= $s['id_sparepart'] ?>"
                                            data-nama="<?= esc($s['nama_sparepart']) ?>"
                                            data-harga="<?= $s['harga_jual'] ?>"
                                            data-stok="<?= $s['stok'] ?>">
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
    let rowAktif = null;

    function addRow() {
        const row = `
            <tr>
                <td>
                    <input type="hidden" name="id_sparepart[]" class="id_sparepart">
                    <div class="input-group">
                        <input type="text" name="nama_sparepart[]" class="form-control nama_sparepart" placeholder="Cari Sparepart..." readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btnCariSparepart">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" name="harga_jual[]" class="form-control text-right harga-jual" readonly>
                </td>
                <td>
                    <input type="number" name="jumlah_jual[]" class="form-control text-center jumlah-jual" value="1" min="1" oninput="calculateSubtotal(this)">
                </td>
                <td>
                    <input type="number" name="stok[]" class="form-control text-center stok" readonly>
                </td>
                <td>
                    <input type="text" name="subtotal[]" class="form-control text-right subtotal" value="0" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#itemRows').append(row);
    }

    function removeRow(btn) {
        $(btn).closest('tr').remove();
        calculateGrandTotal();
    }

    // deleted updatePrice function


    function calculateSubtotal(input) {
        const tr = $(input).closest('tr');
        const harga = parseFloat(tr.find('.harga-jual').val()) || 0;
        const jumlah = parseFloat($(input).val()) || 0;
        const subtotal = harga * jumlah;
        tr.find('.subtotal').val(subtotal);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#total_penjualan').val(total);
    }

    $(document).ready(function() {
        // Tambahkan satu baris kosong saat modal dibuka
        addRow();

        // Open Modal Sparepart
        $(document).on('click', '.btnCariSparepart', function() {
            rowAktif = $(this).closest('tr');
            $('#modalSparepart').modal('show');
        });

        // Pilih Sparepart
        $(document).on('click', '.pilihSparepart', function() {
            if (rowAktif) {
                rowAktif.find('.id_sparepart').val($(this).data('id'));
                rowAktif.find('.nama_sparepart').val($(this).data('nama'));
                rowAktif.find('.harga-jual').val($(this).data('harga'));
                
                // Populate stock field
                let stok = $(this).data('stok');
                rowAktif.find('.stok').val(stok);

                // Set max jumlah sesuai stok
                rowAktif.find('.jumlah-jual').attr('max', stok);
                rowAktif.find('.jumlah-jual').val(1); // Reset jumlah jadi 1

                calculateSubtotal(rowAktif.find('.jumlah-jual'));
                $('#modalSparepart').modal('hide');
            }
        });

        // Cari Sparepart
        $('#cariSparepart').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#tabelSparepart tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Cari Pelanggan
        $('#cariPelanggan').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#tabelPelanggan tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Pilih Pelanggan
        $(document).on('click', '.pilihPelanggan', function() {
            $('#id_pelanggan').val($(this).data('id'));
            $('#nama_pelanggan').val($(this).data('nama'));
            $('#modalPelanggan').modal('hide');
        });

        $('.formsimpan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btn-simpan').attr('disabled', 'disabled');
                    $('.btn-simpan').html('<i class="fa fa-spin fa-spinner"></i> Processor...');
                },
                complete: function() {
                    $('.btn-simpan').removeAttr('disabled');
                    $('.btn-simpan').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        Swal.fire('Error', response.error, 'error');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.sukses,
                        }).then((result) => {
                                $('#modalformtambah').modal('hide');
                                window.location.reload();
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });
    });
</script>
