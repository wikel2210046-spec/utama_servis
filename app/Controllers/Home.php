<?php

namespace App\Controllers;

use App\Models\Mpemesanan;

class Home extends BaseController
{
    protected $pemesananModel;
    public function __construct()
{
    $this->pemesananModel = new Mpemesanan();
}

   public function index()
{
     // Jika sudah login sebagai admin atau pimpinan,
    // langsung arahkan ke dashboard
    if (session()->get('loggedin')) {
        $level = session()->get('level');

        if ($level === 'admin' || $level === 'pimpinan') {
            return redirect()->to(base_url('/Dashboard/dashboard'));
        }
    }
    $servisModel = new \App\Models\Mservis();
    $data['servis'] = $servisModel->findAll();

    // Load daftar mobil jika pelanggan sudah login
    $data['mobil'] = [];
    if (session()->get('loggedin') && session()->get('level') == 'pelanggan') {
        $mobilModel = new \App\Models\Mmobil();
        $data['mobil'] = $mobilModel->getMobilByPelanggan(session()->get('id_pelanggan'));
    }

    return view('template/Beranda', $data);
}


    public function tentang(): string
    {
        return view('template/tentang');
    }

    public function status($kode = null)
    {
        if (!session()->get('loggedin') || session()->get('level') != 'pelanggan') {
            return redirect()->to(base_url('/?showLogin=true'))->with('error', 'Silakan login terlebih dahulu untuk melihat status servis.');
        }

        $idPelanggan = session()->get('id_pelanggan');

        if ($kode) {
            $servis = $this->pemesananModel->getPemesananById($kode);
            if (!$servis || $servis['id_pelanggan'] != $idPelanggan) {
                return redirect()->to(base_url('/Home/status'))->with('error', 'Data pemesanan tidak valid.');
            }
            $data['servis'] = $servis;
            $data['is_detail'] = true;

            // Ambil data transaksi servis (nama mekanik & total biaya) jika status selesai servis
            if ($servis['status'] == 'selesai servis' || $servis['status'] == 'selesai') {
                $db = \Config\Database::connect();
                $transaksi = $db->table('transaksi_servis')
                    ->select('transaksi_servis.total_biaya, mekanik.nama_mekanik')
                    ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
                    ->where('transaksi_servis.id_pemesanan', $servis['id_pemesanan'])
                    ->get()->getRowArray();
                $data['transaksi'] = $transaksi;
            }

            return view('template/status_servis', $data);
        }

        $db = \Config\Database::connect();
        $data['pemesanan'] = $db->table('pemesanan')
            ->select('pemesanan.*, mobil.no_polisi, mobil.merk, mobil.tipe')
            ->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left')
            ->where('pemesanan.id_pelanggan', $idPelanggan)
            ->orderBy('pemesanan.id_pemesanan', 'DESC')
            ->get()->getResultArray();
        $data['is_detail'] = false;

        return view('template/status_servis', $data);
    }
   
    public function layanan()
    {
        $servisModel = new \App\Models\Mservis();
        $data['servis'] = $servisModel->findAll();

        return view('template/service', $data);
    }
    public function faq()
{
    return view('template/faq');
}
    
    public function profil()
    {
        if (!session()->get('loggedin') || session()->get('level') != 'pelanggan') {
            return redirect()->to(base_url('/'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $id_pelanggan = session()->get('id_pelanggan');
        $pelangganModel = new \App\Models\Mpelanggan();
        
        $data = [
            'pelanggan' => $pelangganModel->find($id_pelanggan),
            'username'  => session()->get('nama')
        ];

        return view('template/profil', $data);
    }

    public function updateProfil()
    {
        if (!session()->get('loggedin')) {
            return redirect()->to(base_url('/'));
        }

        $id_pelanggan = session()->get('id_pelanggan');
        $pelangganModel = new \App\Models\Mpelanggan();

        $nama   = $this->request->getPost('nama_pelanggan');
        $email  = $this->request->getPost('email');
        $no_hp  = $this->request->getPost('no_hp');
        $alamat = $this->request->getPost('alamat');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        $dataUpdate = [
            'nama_pelanggan' => $nama,
            'email'          => $email,
            'no_hp'          => $no_hp,
            'alamat'         => $alamat,
        ];

        // Jika password diisi
        if (!empty($password)) {
            if ($password !== $confirm) {
                return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
            }
            $dataUpdate['password'] = md5($password);
        }

        if ($pelangganModel->update($id_pelanggan, $dataUpdate)) {
            // Update session nama jika berubah
            session()->set('nama', $nama);
            return redirect()->to(base_url('Home/profil'))->with('success', 'Profil berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui profil.');
        }
    }

}
