<?php

namespace App\Models;

use CodeIgniter\Model;

class MTransaksiServis extends Model
{
    protected $table = 'transaksi_servis';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'id_mekanik',
        'id_pelanggan',
        'id_pemesanan',
        'tanggal_servis',
        'keluhan',
        'total_biaya'
    ];

    public function getPemesanan($id)
    {
        $pemesanan = $this->pemesananModel
            ->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp')
            ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
            ->where('id_pemesanan', $id)
            ->first();

        return $this->response->setJSON($pemesanan);
    }

    
}
