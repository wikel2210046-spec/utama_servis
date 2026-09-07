<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="card shadow-sm">
    <h3 class="card-title px-3 pt-3">Data Pembayaran</h3>

    <div class="card-header d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-primary btntambah">
            <i class="fa fa-plus"></i> Tambah Pembayaran
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <form action="<?= site_url('Pembayaran/index') ?>" method="post" id="formCari">
                <?= csrf_field() ?>
                <div class="input-group mb-3">
                    <input type="text" name="caripembayaran" id="caripembayaran" class="form-control" placeholder="Cari Nama Pelanggan / No Polisi" autofocus>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" name="tombolcari">Cari</button>
                    </div>
                </div>
            </form>

            <table class="table table-sm table-striped table-bordered align-middle">
                <thead class="thead-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Diambil</th>
                        <th>Nama Pelanggan</th>
                        <th>No Polisi</th>
                        <th>Tipe</th>
                        <th>Total Bayar</th>
                        <th>Diskon</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pembayaran)) : ?>
                        <?php $nomor = 1; ?>
                        <?php foreach ($pembayaran as $row) : ?>
                            <tr class="text-center">
                                <td><?= $nomor++; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_diambil'])); ?></td>
                                <td><?= esc($row['nama_pelanggan']); ?></td>
                                <td><?= esc($row['no_polisi']); ?></td>
                                <td><?= esc($row['tipe']); ?></td>
                                <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($row['diskon'], 0, ',', '.'); ?></td>
                                <td>
                                      <!-- Tombol Invoice -->
                                    <a href="<?= base_url('Pembayaran/invoice/' . $row['id_pembayaran']) ?>" 
                                    target="_blank" class="btn btn-success btn-sm" title="Cetak Invoice">
                                        <i class="fa fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted">Belum ada data pembayaran.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
             <div class="float-center">
                <?= $pager->links('pembayaran', 'paging_data');?>
            </div>
        </div>
    </div>
</div>

<!-- Modal container -->
<div class="viewmodal" style="display:none;"></div>
<div class="viewmodaldetail" style="display:none;"></div>

<script>
$(document).ready(function() {
    // === Tambah Pembayaran ===
    $('.btntambah').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= site_url('Pembayaran/formtambah') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalFormTambah').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log('Ajax error:', xhr.responseText);
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});
// === Lihat Detail Pembayaran ===
function detail(id_pembayaran) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('Pembayaran/detail') ?>",
        data: { id_pembayaran: id_pembayaran },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodaldetail').html(response.data).show();
                $('#modalDetailPembayaran').modal('show');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

</script>

<?= $this->endSection() ?>
