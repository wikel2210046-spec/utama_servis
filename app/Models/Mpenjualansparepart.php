<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpenjualansparepart extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'id_penjualan';
    protected $allowedFields    = [
        'kode_penjualan',
        'id_pelanggan',
        'tanggal_penjualan',
        'diskon'
    ];

    public function getAllPenjualan()
    {
        return $this->select('penjualan.*, pelanggan.nama_pelanggan, (SELECT SUM(jumlah_jual * harga_jual) FROM detail_penjualan WHERE detail_penjualan.id_penjualan = penjualan.id_penjualan) as total_penjualan')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left')
                    ->orderBy('penjualan.tanggal_penjualan', 'DESC')
                    ->findAll();
    }

    public function getDetailPenjualan($id_penjualan)
    {
        return $this->select('penjualan.*, pelanggan.nama_pelanggan, pelanggan.alamat, pelanggan.no_hp')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left')
                    ->where('penjualan.id_penjualan', $id_penjualan)
                    ->first();
    }

    public function getDetailItems($id_penjualan)
    {
        return $this->db->table('detail_penjualan')
                        ->select('detail_penjualan.*, sparepart.nama_sparepart, detail_penjualan.harga_jual, (detail_penjualan.jumlah_jual * detail_penjualan.harga_jual) as subtotal')
                        ->join('sparepart', 'sparepart.id_sparepart = detail_penjualan.id_sparepart', 'left')
                        ->where('detail_penjualan.id_penjualan', $id_penjualan)
                        ->get()
                        ->getResultArray();
    }

    public function hitungTotal($id_penjualan)
    {
        $builder = $this->db->table('detail_penjualan')
                            ->select('SUM(jumlah_jual * harga_jual) as total_penjualan')
                            ->where('id_penjualan', $id_penjualan)
                            ->get()
                            ->getRow();

        return $builder ? $builder->total_penjualan : 0;
    }

    public function updateTotal($id_penjualan)
    {
        return $this->hitungTotal($id_penjualan);
    }

    public function getLaporanPenjualanLengkap()
    {
        return $this->db->table('penjualan')
                        ->select('
                            penjualan.id_penjualan,
                            penjualan.kode_penjualan,
                            penjualan.tanggal_penjualan,
                            pelanggan.nama_pelanggan,
                            sparepart.nama_sparepart,
                            detail_penjualan.harga_jual,
                            detail_penjualan.jumlah_jual,
                            (detail_penjualan.jumlah_jual * detail_penjualan.harga_jual) as subtotal
                        ')
                        ->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan', 'left')
                        ->join('detail_penjualan', 'detail_penjualan.id_penjualan = penjualan.id_penjualan', 'left')
                        ->join('sparepart', 'sparepart.id_sparepart = detail_penjualan.id_sparepart', 'left')
                        ->orderBy('penjualan.tanggal_penjualan', 'DESC')
                        ->get()
                        ->getResultArray();
    }
}
