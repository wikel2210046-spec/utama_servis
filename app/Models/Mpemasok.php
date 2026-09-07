<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpemasok extends Model
{
    protected $table = 'pemasok';
    protected $primaryKey = 'id_pemasok';

    protected $allowedFields = [
        'nama_pemasok',
        'alamat',
        'no_hp',
        'email'
    ];

    // Fungsi untuk mencari pemasok berdasarkan nama
    public function cariData($cari)
    {
        return $this->table('pemasok')->like('nama_pemasok', $cari);
    }
}
