<?= $this->extend('template/home') ?>
<?= $this->section('isi') ?>

<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <h3 class="font-weight-bold text-dark border-bottom pb-2">
                <i class="fas fa-tachometer-alt mr-2 text-primary"></i>Utama Service Station
            </h3>
        </div>
    </div>

    <!-- Baris pertama -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow">
                <div class="inner">
                    <h3><?= $totalTransaksi ?></h3>
                    <p>Total Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <a href="<?= base_url('TransaksiServis/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow">
                <div class="inner">
                    <h3><?= $totalPemesanan ?></h3>
                    <p>Total Pemesanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <a href="<?= base_url('Pemesanan/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow">
                <div class="inner">
                    <h3><?= $totalPemesananAktif ?></h3>
                    <p>Pemesanan Aktif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <a href="<?= base_url('Pemesanan/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger shadow">
                <div class="inner">
                    <h3><?= $totalSparepart ?></h3>
                    <p>Total Sparepart</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="<?= base_url('Sparepart/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Baris kedua -->
    <div class="row mt-3">
        <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-primary shadow">
                <div class="inner">
                    <h3><?= $totalSparepartTerpakai ?></h3>
                    <p>Total Sparepart Terpakai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <a href="<?= base_url('Penjualansparepart/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div> -->

        <div class="col-lg-3 col-6">
            <div class="small-box bg-teal shadow">
                <div class="inner">
                    <h3><?= $totalMekanik ?></h3>
                    <p>Total Mekanik</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <a href="<?= base_url('Mekanik/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple shadow">
                <div class="inner">
                    <h3><?= $totalPelanggan ?></h3>
                    <p>Total Pelanggan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="<?= base_url('Pelanggan/index') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
