<?php
namespace App\Models;

use CodeIgniter\Model;

class MDetailJasa extends Model
{
    protected $table = 'detail_jasa';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_transaksi',
        'id_servis',
        'harga_js'
    ];

    protected $useTimestamps = true;
}
