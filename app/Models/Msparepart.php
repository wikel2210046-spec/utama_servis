<?php

namespace App\Models;

use CodeIgniter\Model;

class Msparepart extends Model
{
    protected $table = 'sparepart';
    protected $primaryKey = 'id_sparepart';

    protected $allowedFields = [
        'nama_sparepart', 
        'no_parts',
        'foto',
        'stok',
        'satuan',
        'harga_beli',
        'harga_jual'
    ];

    // Fungsi untuk mencari pelanggan berdasarkan nama
    public function cariData($cari)
    {
        return $this->table('sparepart')->like('nama_sparepart', $cari);
    }
}
