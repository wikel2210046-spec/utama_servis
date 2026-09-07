<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Madmin;
use App\Models\Mpelanggan;

class Login extends Controller
{
    public function index()
    {
        
        if (!session()->get('loggedin')) {
            $servisModel = new \App\Models\Mservis();
            $data['servis'] = $servisModel->findAll();
            $data['mobil'] = [];
            return view('template/Beranda', $data);
        } else {
            $level = session()->get('level');
            return $this->redirectByLevel($level);
        }
    }

    public function proses()
    {
        $session = session();
        $adminModel = new Madmin();
        $pelangganModel = new Mpelanggan();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // --- Cek ke tabel user (admin/pimpinan) dulu ---
        $user = $adminModel->where('username', $username)->first();
        if ($user) {
            // Cek status aktif
            if ($user['status'] !== 'aktif') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Akun Anda tidak aktif. Hubungi administrator.'
                ]);
            }
            
            if (md5($password) === $user['password']) {
                $data = [
                    'id_admin'  => $user['id_admin'],
                    'nama'     => $user['nama'],
                    'username' => $user['username'],
                    'level'    => $user['level'], // Ambil dari database (admin/pimpinan)
                    'loggedin' => true
                ];
                $session->set($data);
                return $this->response->setJSON([
                    'success' => true,
                    'role'    => $user['level'] // Return level dari database
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Password salah.'
                ]);
            }
        }

        // --- Jika bukan admin, cek tabel pelanggan ---
        $pelanggan = $pelangganModel->where('nama_pelanggan', $username)->orWhere('email', $username)->first();
        if ($pelanggan) {
            if (md5($password) === $pelanggan['password']) {
                $data = [
                    'id_pelanggan' => $pelanggan['id_pelanggan'],
                    'nama'         => $pelanggan['nama_pelanggan'],
                    'level'        => 'pelanggan',
                    'loggedin'     => true
                ];
                $session->set($data);
                return $this->response->setJSON([
                    'success' => true,
                    'role'    => 'pelanggan'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Password salah untuk pelanggan.'
                ]);
            }
        }

        // --- Jika tidak ditemukan di dua tabel ---
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Username atau email tidak ditemukan.'
        ]);
    }
  public function registrasi()
    {
        if ($this->request->isAJAX()) {
            $pelangganModel = new Mpelanggan();

            $nama   = $this->request->getPost('nama_pelanggan');
            $email  = $this->request->getPost('email');
            $no_hp  = $this->request->getPost('no_hp');
            $alamat = $this->request->getPost('alamat');
            $password = $this->request->getPost('password');
            $confirm  = $this->request->getPost('confirm_password');

            // Validasi dasar
            if ($password !== $confirm) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Konfirmasi password tidak cocok.'
                ]);
            }

            // Cek apakah email sudah ada
            if ($pelangganModel->where('email', $email)->first()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email sudah terdaftar.'
                ]);
            }

            // Simpan data pelanggan baru
            $pelangganModel->insert([
                'nama_pelanggan' => $nama,
                'email'          => $email,
                'no_hp'          => $no_hp,
                'alamat'         => $alamat,
                'password'       => md5($password), // menyesuaikan sistem login kamu
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Registrasi berhasil! Silakan login.'
            ]);
        }
         // Jika bukan AJAX (akses biasa), tampilkan halaman registrasi
    return view('template/Registrasi');
    }
    private function redirectByLevel($level)
    {
        if ($level == 'admin' || $level == 'pimpinan') {
            return redirect()->to(base_url('/Dashboard/dashboard'));
        } else {
            return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
