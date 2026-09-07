<?php

namespace App\Models;

use CodeIgniter\Model;

class Mmobil extends Model
{
    protected $table = 'mobil';
    protected $primaryKey = 'id_mobil';

    protected $allowedFields = [
        'id_pelanggan',
        'no_polisi',
        'merk',
        'tipe',
        'jenis',
        'warna',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    /**
     * Ambil data mobil berdasarkan id pelanggan
     */
    public function getMobilByPelanggan($id_pelanggan)
    {
        return $this->where('id_pelanggan', $id_pelanggan)->findAll();
    }
}
