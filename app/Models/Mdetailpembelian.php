<?php

namespace App\Models;

use CodeIgniter\Model;

class Mdetailpembelian extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_pembelian',
        'id_sparepart',
        'jumlah_beli',
        'harga_beli'
    ];

    /**
     * Ambil detail pembelian berdasarkan ID pembelian.
     */
    public function getDetailByPembelian($id_pembelian)
    {
        return $this->select('detail_pembelian.*, sparepart.nama_sparepart, sparepart.satuan')
                    ->join('sparepart', 'sparepart.id_sparepart = detail_pembelian.id_sparepart')
                    ->where('detail_pembelian.id_pembelian', $id_pembelian)
                    ->findAll();
    }

    /**
     * Hitung total nominal pembelian.
     */
    public function getTotalByPembelian($id_pembelian)
    {
        return $this->where('id_pembelian', $id_pembelian)
                    ->select('SUM(jumlah_beli * harga_beli) as subtotal')
                    ->get()
                    ->getRowArray();
    }

    /**
     * Hapus semua detail berdasarkan ID pembelian (misalnya saat rollback).
     */
    public function hapusByPembelian($id_pembelian)
    {
        return $this->where('id_pembelian', $id_pembelian)->delete();
    }
}
