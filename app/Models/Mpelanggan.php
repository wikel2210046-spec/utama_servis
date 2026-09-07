<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    protected $allowedFields = [
        'nama_pelanggan',
        'email',
        'password',
        'alamat',
        'no_hp'
    ];

    // Fungsi untuk mencari pelanggan berdasarkan nama
   public function cariData($cari)
    {
        return $this->where('nama_pelanggan LIKE', "%$cari%");
    }
}
