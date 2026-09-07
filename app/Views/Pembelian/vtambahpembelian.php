<!-- Modal Tambah Pembelian Sparepart -->
<div class="modal fade" id="modalformtambah" tabindex="-1" aria-labelledby="modalformtambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- pakai modal besar biar muat -->
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalformtambahLabel">
                    Tambah Pembelian Sparepart
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="formtambahpembelian">
                    <?= csrf_field() ?>

                    <!-- Baris Pertama: Kode, Pemasok, Tanggal -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="kode_pembelian" class="form-label">Kode Pembelian</label>
                            <input type="text" class="form-control" id="kode_pembelian" name="kode_pembelian" placeholder="Masukkan kode..." required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pemasok</label>
                            <input type="hidden" name="id_pemasok" id="id_pemasok" required>
                            <div class="input-group">
                                <input type="text" id="nama_pemasok" class="form-control" placeholder="Pilih pemasok..." readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPemasok">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <hr>

                    <!-- Baris Kedua: Tabel Sparepart -->
                    <h5>Daftar Item Sparepart</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="tabelItem">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th>Sparepart</th>
                                    <th width="15%">Jumlah</th>
                                    <th width="20%">Harga (Rp)</th>
                                    <th width="20%">Subtotal (Rp)</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemRows">
                                <!-- Rows dynamic -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <button type="button" class="btn btn-success btn-sm" id="tambahBaris">
                                            <i class="fa fa-plus"></i> Tambah Baris
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-group">
                        <label for="total_pembelian">Total Harga (Rp)</label>
                        <input type="number" class="form-control text-right font-weight-bold" id="total_pembelian" name="total_pembelian" min="0" readonly style="font-size: 1.2rem;">
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnsimpanpembelian">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pemasok -->
<div class="modal fade" id="modalPemasok">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Pilih Pemasok</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="cariPemasok" class="form-control" placeholder="Cari nama pemasok...">
                </div>
                <div style="max-height:400px; overflow-y:auto;">
                    <table class="table table-bordered table-hover" id="tabelPemasok">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Pemasok</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pemasok as $p): ?>
                                <tr>
                                    <td><?= esc($p['nama_pemasok']) ?></td>
                                    <td><?= esc($p['alamat'] ?? '-') ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm pilihPemasok"
                                            data-id="<?= $p['id_pemasok'] ?>"
                                            data-nama="<?= esc($p['nama_pemasok']) ?>">
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

<!-- Modal Sparepart -->
<div class="modal fade" id="modalSparepart">
    <div class="modal-dialog modal-gl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Pilih Sparepart</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="cariSparepart" class="form-control" placeholder="Cari nama sparepart...">
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
                                        <button type="button" class="btn btn-success btn-sm pilihSparepart"
                                            data-id="<?= $s['id_sparepart'] ?>"
                                            data-nama="<?= esc($s['nama_sparepart']) ?>">
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
                        <input type="text" class="form-control nama_sparepart" placeholder="Cari Sparepart..." readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btnCariSparepart">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" name="jumlah_beli[]" class="form-control text-center jumlah_beli" value="1" min="1" oninput="calculateSubtotal(this)">
                </td>
                <td>
                    <input type="number" name="harga_beli[]" class="form-control text-right harga_beli" value="0" min="0" oninput="calculateSubtotal(this)">
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

    function calculateSubtotal(input) {
        const tr = $(input).closest('tr');
        const jumlah = parseFloat(tr.find('.jumlah_beli').val()) || 0;
        const harga = parseFloat(tr.find('.harga_beli').val()) || 0;
        const subtotal = jumlah * harga;
        tr.find('.subtotal').val(subtotal);
        calculateGrandTotal();
    }

    function calculateGrandTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $('#total_pembelian').val(total);
    }

    $(document).ready(function() {
        // Init row
        addRow();

        // Cari Pemasok
        $('#cariPemasok').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $('#tabelPemasok tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Pilih Pemasok
        $(document).on('click', '.pilihPemasok', function() {
            $('#id_pemasok').val($(this).data('id'));
            $('#nama_pemasok').val($(this).data('nama'));
            $('#modalPemasok').modal('hide');
        });

        // Tambah Baris
        $('#tambahBaris').click(function() {
            addRow();
        });

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

        // Simpan via AJAX
        $('#btnsimpanpembelian').click(function() {
            $.ajax({
                type: "POST",
                url: "<?= site_url('Pembeliansparepart/simpan') ?>",
                data: $('#formtambahpembelian').serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#btnsimpanpembelian').attr('disabled', 'disabled').html('<i class="fa fa-spin fa-spinner"></i> Processor...');
                },
                complete: function() {
                    $('#btnsimpanpembelian').removeAttr('disabled').html('<i class="fa fa-save"></i> Simpan');
                },
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire('Berhasil', response.sukses, 'success').then(() => {
                            $('#modalformtambah').modal('hide');
                            window.location.reload();
                        });
                    } else if (response.error) {
                        Swal.fire('Gagal', response.error, 'error');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire('Error', xhr.status + ' ' + thrownError, 'error');
                }
            });
        });
    });
</script>