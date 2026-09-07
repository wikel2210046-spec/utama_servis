<?php

namespace App\Models;

use CodeIgniter\Model;

class Madmin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $allowedFields = ['nama', 'username', 'password', 'level', 'status'];

   public function cariData($cari)
    {
        return $this->table('admin')->like('username', $cari);
    }
}
