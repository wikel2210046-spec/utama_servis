<?php

namespace App\Models;

use CodeIgniter\Model;

class Mservis extends Model
{
    protected $table = 'jenis_servis';
    protected $primaryKey = 'id_servis';

    protected $allowedFields = [
        'nama_servis', 
        'deskripsi',
        'harga_servis',
    ];

    // Fungsi untuk mencari pelanggan berdasarkan nama
    public function cariData($cari)
    {
        return $this->table('jenis_servis')->like('nama_servis', $cari);
    }
}
