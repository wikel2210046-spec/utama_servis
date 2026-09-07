<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';

    protected $allowedFields = [
        'id_pelanggan',
        'kode_pemesanan',
        'tanggal_servis',
        'jam_servis',
        'id_mobil',
        'keluhan',
        'status',
        'created_at',
        'updated_at'
    ];

    // Aktifkan timestamp otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    /**
     * Ambil semua data pemesanan dengan join nama pelanggan
     */
    public function getAllPemesanan()
    {
        return $this->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp, mobil.no_polisi, mobil.merk, mobil.tipe, mobil.warna')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
                    ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
                    ->orderBy('pemesanan.id_pemesanan', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil data pemesanan berdasarkan ID (dengan data pelanggan)
     */
   public function getPemesananById($id)
{
    return $this->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp, mobil.no_polisi, mobil.merk, mobil.tipe, mobil.warna')
                ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
                ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
                ->groupStart()
                    ->where('pemesanan.id_pemesanan', $id)
                    ->orWhere('pemesanan.kode_pemesanan', $id)
                ->groupEnd()
                ->first();
}


    /**
     * Ambil daftar pemesanan berdasarkan status
     * contoh: getByStatus('proses')
     */
    public function getByStatus($status)
    {
        return $this->select('pemesanan.*, pelanggan.nama_pelanggan, pelanggan.no_hp, mobil.no_polisi, mobil.merk, mobil.tipe, mobil.warna')
                    ->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan')
                    ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
                    ->where('pemesanan.status', $status)
                    ->orderBy('tanggal_servis', 'DESC')
                    ->findAll();
    }

    /**
     * Ubah status pemesanan (pesan → proses → selesai)
     */
    public function updateStatus($id_pemesanan, $status)
    {
        return $this->update($id_pemesanan, ['status' => $status]);
    }
}
