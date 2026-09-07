<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $allowedFields = [
        'id_transaksi',
        'tanggal_diambil',
        'total_bayar',
        'diskon'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
