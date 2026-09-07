<?php

namespace App\Controllers;
use App\Models\MTransaksiServis;
use App\Models\Mmekanik;
use CodeIgniter\Controller;

class Dashboard extends Controller
{

      protected $transaksiModel;
    protected $mekanikModel;
     protected $db;
    public function __construct()
    {
        $this->transaksiModel  = new MTransaksiServis();
        $this->mekanikModel    = new Mmekanik();
         $this->db              = \Config\Database::connect();
    }
   public function index()
{
    // Cek session login
    if (!session()->get('loggedin')) {
        return redirect()->to(base_url('/login'));
    }

    // Ambil level user
    $level = session()->get('level');

    // Redirect berdasarkan level ke dashboard
    switch ($level) {
        case 'admin':
        case 'pimpinan':
             return redirect()->to(base_url('/Dashboard/dashboard'));
        default:
            // Jika level tidak dikenali, logout
            session()->destroy();
            return redirect()->to(base_url('/login'));
    }
}
public function dashboard()
{
    // Total transaksi
    $totalTransaksi = $this->transaksiModel->countAllResults();

    // Total pemesanan
    $totalPemesanan = $this->db->table('pemesanan')->countAllResults();

    // Total pemesanan aktif (status pesan & proses)
    $totalPemesananAktif = $this->db->table('pemesanan')
        ->whereIn('status', ['pesan', 'proses'])
        ->countAllResults();

    // Total pendapatan
    $totalPendapatan = $this->db->table('transaksi_servis')
        ->selectSum('total_biaya')
        ->get()
        ->getRowArray()['total_biaya'] ?? 0;

    // Total sparepart terpakai
    $totalSparepartTerpakai = $this->db->table('detail_sparepart_servis')
        ->selectSum('jumlah_sp', 'jumlah')
        ->get()
        ->getRowArray()['jumlah'] ?? 0;

    // Total sparepart di stok
    $totalSparepart = $this->db->table('sparepart')->countAllResults();

    // Total mekanik
    $totalMekanik = $this->mekanikModel->countAllResults();

    // Total pelanggan
    $totalPelanggan = $this->db->table('pelanggan')->countAllResults();

    // Tahun sekarang
    $tahunSekarang = date('Y');

    // Pendapatan per bulan
    $pendapatanBulanan = $this->db->query("
        SELECT 
            MONTH(tanggal_servis) AS bulan, 
            SUM(total_biaya) AS total
        FROM transaksi_servis
        WHERE YEAR(tanggal_servis) = $tahunSekarang
        GROUP BY MONTH(tanggal_servis)
        ORDER BY bulan ASC
    ")->getResultArray();

    // Array bulan
    $bulanLengkap = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    $total = array_fill(1, 12, 0);
    foreach ($pendapatanBulanan as $row) {
        $total[(int)$row['bulan']] = (float)$row['total'];
    }

    $bulan = json_encode($bulanLengkap);
    $total = json_encode(array_values($total));

    $data = [
        'title' => 'Dashboard',
        'totalTransaksi' => $totalTransaksi,
        'totalPemesanan' => $totalPemesanan,
        'totalPemesananAktif' => $totalPemesananAktif, // ⬅️ DITAMBAHKAN
        'totalPendapatan' => $totalPendapatan,
        'totalSparepartTerpakai' => $totalSparepartTerpakai,
        'totalSparepart' => $totalSparepart,
        'totalMekanik' => $totalMekanik,
        'totalPelanggan' => $totalPelanggan,
        'bulan' => $bulan,
        'total' => $total,
    ];

    return view('template/dashboard', $data);
}

}
