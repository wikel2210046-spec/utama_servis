<?php

namespace App\Models;

use CodeIgniter\Model;

class Muangkeluar extends Model
{
    protected $table = 'uang_keluar';
    protected $primaryKey = 'id_uang_keluar';

    protected $allowedFields = [
        'tanggal',
        'jenis_pengeluaran',
        'jumlah',
        'keterangan'
    ];

    public function cariData($cari)
    {
        return $this->table('uang_keluar')
            ->like('jenis_pengeluaran', $cari)
            ->orLike('keterangan', $cari);
    }
}
