<?php

namespace App\Controllers;

use App\Models\Mpemesanan;
use App\Models\Mpelanggan;
use App\Models\Mmobil;

class Booking extends BaseController
{
    protected $pemesananModel;
    protected $pelangganModel;
    protected $mobilModel;

    public function __construct()
    {
        $this->pemesananModel = new Mpemesanan();
        $this->pelangganModel = new Mpelanggan();
        $this->mobilModel = new Mmobil();
        helper(['form', 'url']);
    }

    public function index()
    {
        $session = session();
        $id_pelanggan = $session->get('id_pelanggan');
        $pelanggan = $this->pelangganModel->find($id_pelanggan);
        
        $mobil = [];
        if ($id_pelanggan) {
            $mobil = $this->mobilModel->getMobilByPelanggan($id_pelanggan);
        }

        return view('template/booking', [
            'pelanggan' => $pelanggan,
            'mobil' => $mobil
        ]);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $session = session();
            $id_pelanggan = $session->get('id_pelanggan');

            if (!$id_pelanggan) {
                return $this->response->setJSON([
                    'success' => false,
                    'redirect' => site_url('/?showLogin=true'),
                    'message' => 'Silakan login terlebih dahulu untuk melakukan pemesanan.'
                ]);
            }

            $tanggal_servis = $this->request->getPost('tanggal_servis');
            $jam_servis     = $this->request->getPost('jam_servis');
            $id_mobil   = $this->request->getPost('id_mobil');
            $keluhan        = $this->request->getPost('keluhan');

            if (empty($tanggal_servis) || empty($jam_servis)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tanggal dan jam servis wajib diisi!'
                ]);
            }
            $last = $this->pemesananModel
                ->like('kode_pemesanan', 'USSP-' . date('Ymd'), 'after')
                ->orderBy('kode_pemesanan', 'DESC')
                ->first();

            $no = $last ? (int)substr($last['kode_pemesanan'], -3) + 1 : 1;
            $kodePemesanan = 'USSP-' . date('Ymd') . '-' . str_pad($no, 3, '0', STR_PAD_LEFT);

            $pemesananModel = new Mpemesanan();

            // 1. Cek slot penuh
            $kapasitasTeknisi = 3;
            $jumlahSlot = $pemesananModel
                ->where('tanggal_servis', $tanggal_servis)
                ->where('jam_servis', $jam_servis)
                ->countAllResults();

            if ($jumlahSlot >= $kapasitasTeknisi) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Slot waktu ini sudah penuh. Silakan pilih waktu lain.'
                ]);
            }

            // 2. Cek mobil double booking pada slot yang sama
            $mobilDouble = $pemesananModel
                ->where('id_mobil', $id_mobil)
                ->where('tanggal_servis', $tanggal_servis)
                ->where('jam_servis', $jam_servis)
                ->first();

            if ($mobilDouble) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Mobil ini sudah dipesan pada waktu yang sama.'
                ]);
            }

            // 3. Cek mobil masih dalam pengerjaan (status pesan atau proses)
            $mobilSedangDikerjakan = $pemesananModel
                ->where('id_mobil', $id_mobil)
                ->whereIn('status', ['pesan', 'proses'])
                ->first();

            if ($mobilSedangDikerjakan) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Mobil ini masih dalam pengerjaan di bengkel. Tidak bisa melakukan pemesanan baru sebelum selesai.'
                ]);
            }

            // Simpan pemesanan
            $data = [
                'id_pelanggan'   => $id_pelanggan,
                'tanggal_servis' => $tanggal_servis,
                'jam_servis'     => $jam_servis,
                'id_mobil'   => $id_mobil,
                'keluhan'        => $keluhan,
                'status'         => 'pesan',
                 'kode_pemesanan' => $kodePemesanan
            ];

            if ($pemesananModel->insert($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Pemesanan berhasil! Kode Pemesanan Anda: ' . $kodePemesanan . ' Tim Kami akan segera menghubungi Anda'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menyimpan data pemesanan.',
                    'kode_pemesanan' => $kodePemesanan
                ]);
            }
        }
    }
}
