<?php

namespace App\Controllers;

use App\Models\Mpemasok;
use CodeIgniter\Controller;

class Pemasok extends BaseController
{
    protected $PemasokModel;

    public function __construct()
    {
        $this->PemasokModel = new Mpemasok();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolpemasok');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('caripemasok');
            session()->set('caripemasok', $cari);
            redirect()->to('/Pemasok/index');
        } else {
            $cari = session()->get('caripemasok');
        }

        // Ambil data pemasok berdasarkan pencarian
        $Pemasok = $cari ? $this->PemasokModel->cariData($cari) : $this->PemasokModel;
        $noHalaman = $this->request->getVar('page_pemasok') ? $this->request->getVar('page_pemasok') : 1;

        // Kirimkan data ke view
        $data = [
            'Pemasok' => $Pemasok->paginate(10, 'pemasok'),
            'pager'   => $this->PemasokModel->pager,
            'cari'    => $cari
        ];

        return view('Pemasok/Vpemasok', $data);
    }

    // Form tambah data
    public function formtambah()
    {
        $msg = [
            'data' => view('Pemasok/VtambahPemasok')
        ];
        echo json_encode($msg);
    }

    // Simpan data pemasok baru
    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $nama_pemasok = $this->request->getPost('nama_pemasok');
            $alamat       = $this->request->getPost('alamat');
            $no_hp        = $this->request->getPost('no_hp');
            $email        = $this->request->getPost('email');

            // Validasi input
            if (empty($nama_pemasok) || empty($alamat) || empty($no_hp)) {
                $msg = [
                    'success' => false,
                    'message' => 'Semua field wajib diisi!'
                ];
                echo json_encode($msg);
                return;
            }
             $cekNama = $this->PemasokModel->where('nama_pemasok', $nama_pemasok)->first();
        if ($cekNama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Pemasok sudah digunakan!'
            ]);
        }
          $cekemail = $this->PemasokModel->where('email', $email)->first();
        if ($cekemail) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Email sudah digunakan!'
            ]);
        }
            // Simpan ke database
            $data = [
                'nama_pemasok' => $nama_pemasok,
                'alamat'       => $alamat,
                'no_hp'        => $no_hp,
                'email'        => $email
            ];

            $this->PemasokModel->insert($data);

            $msg = [
                'success' => true,
                'message' => 'Data Pemasok berhasil ditambahkan!'
            ];
            echo json_encode($msg);
        }
    }

    // Form edit data pemasok
    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_pemasok = $this->request->getPost('id_pemasok');
            $ambilData = $this->PemasokModel->find($id_pemasok);

            if ($ambilData) {
                $data = [
                    'id_pemasok'   => $id_pemasok,
                    'nama_pemasok' => $ambilData['nama_pemasok'],
                    'alamat'       => $ambilData['alamat'],
                    'no_hp'        => $ambilData['no_hp'],
                    'email'        => $ambilData['email'],
                ];

                $msg = [
                    'data' => view('Pemasok/VeditPemasok', $data)
                ];
            } else {
                $msg = [
                    'error' => 'Data tidak ditemukan'
                ];
            }

            echo json_encode($msg);
        }
    }

    // Update data pemasok
    public function updateData()
    {
        if ($this->request->isAJAX()) {
            $id_pemasok   = $this->request->getVar('id_pemasok');
            $nama_pemasok = $this->request->getVar('nama_pemasok');
            $alamat       = $this->request->getVar('alamat');
            $no_hp        = $this->request->getVar('no_hp');
            $email        = $this->request->getVar('email');

            $this->PemasokModel->update($id_pemasok, [
                'nama_pemasok' => $nama_pemasok,
                'alamat'       => $alamat,
                'no_hp'        => $no_hp,
                'email'        => $email
            ]);

            $msg = [
                'sukses' => 'Data Pemasok berhasil diupdate!'
            ];
            echo json_encode($msg);
        }
    }

    // Hapus data pemasok
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_pemasok = $this->request->getVar('id_pemasok');
            $this->PemasokModel->delete($id_pemasok);

            $msg = [
                'sukses' => 'Data Pemasok berhasil dihapus!'
            ];
            echo json_encode($msg);
        }
    }

    // Laporan semua pemasok
    public function laporan()
    {
        $dataPemasok = $this->PemasokModel->findAll();
        $username = session()->get('username');

        $data = [
            'title'       => 'Laporan Data Pemasok',
            'dataPemasok' => $dataPemasok,
            'username'    => session()->get('nama'),
        ];

        return view('Pemasok/laporan_pemasok', $data);
    }
}
