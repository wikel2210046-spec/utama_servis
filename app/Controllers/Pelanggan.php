<?php

namespace App\Controllers;

use App\Models\Mpelanggan;
use CodeIgniter\Controller;

class Pelanggan extends BaseController
{
    protected $PelangganModel;

    public function __construct()
    {
        $this->PelangganModel = new Mpelanggan();
        helper(['form', 'url']);
    }

    public function index()
    {
        $tombolCari = $this->request->getPost('tombolPelanggan');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caripelanggan');
            session()->set('caripelanggan', $cari);
            return redirect()->to('/Pelanggan/index');
        } else {
            $cari = session()->get('caripelanggan');
        }

        $Pelanggan = $cari ? $this->PelangganModel->cariData($cari) : $this->PelangganModel;
        $noHalaman = $this->request->getVar('page_pelanggan') ? $this->request->getVar('page_pelanggan') : 1;

        $data = [
            'Pelanggan' => $Pelanggan->paginate(10, 'pelanggan'),
            'pager' => $this->PelangganModel->pager,
            'cari' => $cari
        ];

        return view('Pelanggan/Vpelanggan', $data);
    }

    public function formtambah()
    {
        $msg = [
            'data' => view('Pelanggan/VtambahPelanggan')
        ];
        echo json_encode($msg);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $nama_pelanggan = $this->request->getPost('nama_pelanggan');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $alamat = $this->request->getPost('alamat');
            $no_hp = $this->request->getPost('no_hp');

            // 🔍 Validasi input
            if (empty($nama_pelanggan) || empty($email) || empty($password) || empty($alamat) || empty($no_hp)) {
                $msg = [
                    'success' => false,
                    'message' => 'Semua field wajib diisi!'
                ];
                echo json_encode($msg);
                return;
            }

               $cekNama = $this->PelangganModel->where('nama_pelanggan', $nama_pelanggan)->first();
        if ($cekNama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama pelanggan sudah digunakan!'
            ]);
        }
          $cekUsername = $this->PelangganModel->where('email', $email)->first();
            if ($cekUsername) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email sudah digunakan!'
                ]);
            }
            // 🔐 Enkripsi password pakai md5
            $hashedPassword = md5($password);

            $data = [
                'nama_pelanggan' => $nama_pelanggan,
                'email' => $email,
                'password' => $hashedPassword,
                'alamat' => $alamat,
                'no_hp' => $no_hp
            ];

            $this->PelangganModel->insert($data);

            $msg = [
                'success' => true,
                'message' => 'Data pelanggan berhasil ditambahkan!'
            ];
            echo json_encode($msg);
        }
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_pelanggan = $this->request->getPost('id_pelanggan');
            $ambilDataPelanggan = $this->PelangganModel->find($id_pelanggan);

            if ($ambilDataPelanggan) {
                $data = [
                    'id_pelanggan' => $id_pelanggan,
                    'nama_pelanggan' => $ambilDataPelanggan['nama_pelanggan'],
                    'email' => $ambilDataPelanggan['email'],
                    'password'=> $ambilDataPelanggan['password'],
                    'alamat' => $ambilDataPelanggan['alamat'],
                    'no_hp' => $ambilDataPelanggan['no_hp']
                ];

                $msg = [
                    'data' => view('Pelanggan/VeditPelanggan', $data)
                ];
            } else {
                $msg = [
                    'error' => 'Data tidak ditemukan'
                ];
            }

            echo json_encode($msg);
        }
    }
    public function updateData()
    {
        if ($this->request->isAJAX()) {
            $id_pelanggan = $this->request->getVar('id_pelanggan');
            $nama_pelanggan = $this->request->getVar('nama_pelanggan');
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $alamat = $this->request->getVar('alamat');
            $no_hp = $this->request->getVar('no_hp');
            
            
            if (!empty($password)) {
                $password = md5($password);
            } else {
            // Jika password kosong, gunakan password lama
            $existingData = $this->PelangganModel->find($id_pelanggan);
            $password = $existingData['password'];
        }
              // Update data admin di database
            $this->PelangganModel->update($id_pelanggan, [
                'nama_pelanggan'=> $nama_pelanggan,
                'email' => $email,
                'alamat' => $alamat,
                'password' => $password ?? null,  // Jika password kosong, tidak perlu di-update
                'no_hp' => $no_hp,
            ]);

            $msg = [
                'sukses' => 'Data pelanggan berhasil diperbarui!'
            ];
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_pelanggan = $this->request->getVar('id_pelanggan');
            $this->PelangganModel->delete($id_pelanggan);

            $msg = [
                'sukses' => 'Data pelanggan berhasil dihapus!'
            ];
            echo json_encode($msg);
        }
    }

    public function laporan()
    {
        $dataPelanggan = $this->PelangganModel->findAll();
        $username = session()->get('username');
        $data = [
            'title' => 'Laporan Data Pelanggan',
            'dataPelanggan' => $dataPelanggan,
            'username' => session()->get('nama'),
        ];
        return view('Pelanggan/laporan_pelanggan', $data);
    }
}
