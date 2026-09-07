<?php

namespace App\Models;

use CodeIgniter\Model;

class Mdetailpenjualan extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_penjualan',
        'id_sparepart',
        'jumlah_jual',
        'harga_jual'
    ];

    public function getDetailByPenjualan($id_penjualan)
    {
        return $this->select('detail_penjualan.*, sparepart.nama_sparepart, sparepart.satuan')
                    ->join('sparepart', 'sparepart.id_sparepart = detail_penjualan.id_sparepart')
                    ->where('detail_penjualan.id_penjualan', $id_penjualan)
                    ->findAll();
    }

    public function getTotalByPenjualan($id_penjualan)
    {
        return $this->where('id_penjualan', $id_penjualan)
                    ->select('SUM(jumlah_jual * harga_jual) as subtotal')
                    ->get()
                    ->getRowArray();
    }

    public function hapusByPenjualan($id_penjualan)
    {
        return $this->where('id_penjualan', $id_penjualan)->delete();
    }
}
