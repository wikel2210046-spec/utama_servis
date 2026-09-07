<?php
namespace App\Models;

use CodeIgniter\Model;

class MDetailSparepartServis extends Model
{
    protected $table = 'detail_sparepart_servis';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_transaksi',
        'id_sparepart',
        'jumlah_sp',
        'harga_sp'
    ];

    protected $useTimestamps = true;
}
