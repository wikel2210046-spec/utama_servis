<?php

namespace App\Controllers;

use App\Models\Mmobil;

class Mobil extends BaseController
{
    protected $mobilModel;

    public function __construct()
    {
        $this->mobilModel = new Mmobil();
    }

    public function index()
    {
        if (!session()->get('loggedin') || session()->get('level') != 'pelanggan') {
            return redirect()->to(base_url('/'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $idPelanggan = session()->get('id_pelanggan');
        $data['mobil'] = $this->mobilModel->getMobilByPelanggan($idPelanggan);

        return view('template/mobil', $data);
    }

    public function tambah()
    {
        if (!session()->get('loggedin') || session()->get('level') != 'pelanggan') {
            return redirect()->to(base_url('/'));
        }

        $idPelanggan = session()->get('id_pelanggan');

        $data = [
            'id_pelanggan' => $idPelanggan,
            'no_polisi'    => $this->request->getPost('no_polisi'),
            'merk'         => $this->request->getPost('merk'),
            'tipe'         => $this->request->getPost('tipe'),
            'jenis'        => $this->request->getPost('jenis'),
            'warna'        => $this->request->getPost('warna'),
        ];

        if ($this->mobilModel->insert($data)) {
            // Check if redirect comes from booking
            if ($this->request->getPost('from_booking')) {
                return redirect()->to(base_url('/Booking'))->with('success', 'Mobil berhasil ditambahkan, silakan lanjutkan pemesanan.');
            }
            return redirect()->to(base_url('/Mobil'))->with('success', 'Mobil berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan mobil.');
        }
    }

    public function hapus($id)
    {
        if (!session()->get('loggedin') || session()->get('level') != 'pelanggan') {
            return redirect()->to(base_url('/'));
        }

        $mobil = $this->mobilModel->find($id);
        
        // Pastikan mobil milik pelanggan yang sedang login
        if ($mobil && $mobil['id_pelanggan'] == session()->get('id_pelanggan')) {
            // Cek apakah mobil ini sudah digunakan di pemesanan (Optional, tapi DB pakai RESTRICT jadi akan gagal jika dipakai)
            try {
                $this->mobilModel->delete($id);
                return redirect()->to(base_url('/Mobil'))->with('success', 'Mobil berhasil dihapus.');
            } catch (\Exception $e) {
                return redirect()->to(base_url('/Mobil'))->with('error', 'Gagal menghapus mobil. Mobil sedang digunakan pada transaksi servis.');
            }
        }

        return redirect()->to(base_url('/Mobil'))->with('error', 'Mobil tidak ditemukan.');
    }
}
