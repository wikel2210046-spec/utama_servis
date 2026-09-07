<?php
namespace App\Models;

use CodeIgniter\Model;

class Mpembeliansparepart extends Model
{
    protected $table            = 'pembelian';
    protected $primaryKey       = 'id_pembelian';
    protected $allowedFields    = [
        'kode_pembelian',
        'id_pemasok',
        'tanggal_pembelian'
    ];
    
    public function getAllPembelian()
    {
        return $this->select('pembelian.*, pemasok.nama_pemasok, SUM(detail_pembelian.jumlah_beli * detail_pembelian.harga_beli) as total_pembelian')
                    ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok', 'left')
                    ->join('detail_pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian', 'left')
                    ->groupBy('pembelian.id_pembelian')
                    ->orderBy('pembelian.tanggal_pembelian', 'DESC')
                    ->findAll();
    }
    public function getDetailPembelian($id_pembelian)
    {
        return $this->select('pembelian.*, pemasok.nama_pemasok, pemasok.alamat, pemasok.no_hp')
                    ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok', 'left')
                    ->where('pembelian.id_pembelian', $id_pembelian)
                    ->first();
    }

    public function getDetailItems($id_pembelian)
    {
        return $this->db->table('detail_pembelian')
                        ->select('detail_pembelian.*, sparepart.nama_sparepart, detail_pembelian.harga_beli, (detail_pembelian.jumlah_beli * detail_pembelian.harga_beli) as subtotal')
                        ->join('sparepart', 'sparepart.id_sparepart = detail_pembelian.id_sparepart', 'left')
                        ->where('detail_pembelian.id_pembelian', $id_pembelian)
                        ->get()
                        ->getResultArray();
    }
    public function hitungTotal($id_pembelian)
    {
        $builder = $this->db->table('detail_pembelian')
                            ->select('SUM(jumlah_beli * harga_beli) as total_pembelian')
                            ->where('id_pembelian', $id_pembelian)
                            ->get()
                            ->getRow();

        return $builder ? $builder->total_pembelian : 0;
    }

    public function updateTotal($id_pembelian)
    {
        // Karena field total_pembelian sudah tidak ada di tabel pembelian, 
        // fungsi ini tidak lagi melakukan update ke database, tetapi tetap bisa digunakan
        // untuk mendapatkan total jika dibutuhkan oleh controller.
        return $this->hitungTotal($id_pembelian);
    }
public function getLaporanPembelianLengkap()
{
    return $this->db->table('pembelian')
                    ->select('
                        pembelian.id_pembelian,
                        pembelian.kode_pembelian,
                        pembelian.tanggal_pembelian,
                        pemasok.nama_pemasok,
                        sparepart.nama_sparepart,
                        detail_pembelian.harga_beli,
                        detail_pembelian.jumlah_beli,
                        (detail_pembelian.jumlah_beli * detail_pembelian.harga_beli) as subtotal
                    ')
                    ->join('pemasok', 'pemasok.id_pemasok = pembelian.id_pemasok', 'left')
                    ->join('detail_pembelian', 'detail_pembelian.id_pembelian = pembelian.id_pembelian', 'left')
                    ->join('sparepart', 'sparepart.id_sparepart = detail_pembelian.id_sparepart', 'left')
                    ->orderBy('pembelian.tanggal_pembelian', 'DESC')
                    ->get()
                    ->getResultArray();
}

}
