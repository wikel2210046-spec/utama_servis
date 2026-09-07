<?php

namespace App\Models;

use CodeIgniter\Model;

class Mmekanik extends Model
{
    protected $table = 'mekanik';
    protected $primaryKey = 'id_mekanik';

    protected $allowedFields = [
        'nama_mekanik', 
        'no_hp',
         'alamat',
         'status'
    ];

    // Fungsi untuk mencari pelanggan berdasarkan nama
    public function cariData($cari)
    {
        return $this->table('mekanik')->like('nama_mekanik', $cari);
    }
    
      public function getMekanikAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }
}
