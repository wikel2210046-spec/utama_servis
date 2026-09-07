<?php

namespace App\Controllers;

use App\Models\Madmin;
use CodeIgniter\Controller;

class Admin extends BaseController
{
    protected $AdminModel;

    public function __construct()
    {
        $this->AdminModel = new Madmin();
        helper(['form', 'url']);
    }

     public function index()
    {
        // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolAdmin');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('cariadmin');
            session()->set('cariadmin', $cari);
            redirect()->to('/Admin/index');
        } else {
            $cari = session()->get('cariadmink');
        }

        // Ambil data pelanggan berdasarkan pencarian
        $Admin = $cari ? $this->AdminModel->cariData($cari) : $this->AdminModel;
        $noHalaman = $this->request->getVar('page_admin') ? $this->request->getVar('page_admin') : 1;

        // Kirimkan data ke view
        $data = [
            'Admin' => $Admin->paginate(10, 'user'),
            'pager' => $this->AdminModel->pager,
            'cari' => $cari
        ];

        return view('Admin/Vadmin', $data);
    }

    public function formtambah()
{
    $msg = [
        'data' => view('Admin/VtambahAdmin')
    ];
    echo json_encode($msg);
}

    public function simpan()
{
    if ($this->request->isAJAX()) {

        // Ambil data dari form
        $nama = $this->request->getVar('nama');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $level    = $this->request->getPost('level');
        

        // Validasi input sederhana
        if (empty($nama) ||   empty($username) || empty($password) || empty($level)) {
            $msg = [
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ];
            echo json_encode($msg);
            return;
        }

          $cekUsername = $this->AdminModel->where('username', $username)->first();
            if ($cekUsername) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Username sudah digunakan!'
                ]);
            }

        // Hash password pakai md5 (ikuti struktur kamu)
        $hashedPassword = md5($password);

        // Siapkan data untuk disimpan
        $data = [
            'nama'=> $nama,
            'username' => $username,
            'password' => $hashedPassword,
            'level'    => $level
        ];

        // Simpan ke database
        $this->AdminModel->insert($data);

        // Kirim respons ke AJAX
        $msg = [
            'success' => true,
            'message' => 'Data admin berhasil ditambahkan!'
        ];
        echo json_encode($msg);
    }
}


 public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_admin = $this->request->getPost('id_admin');
            $ambilDataAdmin = $this->AdminModel->find($id_admin);
            
            if ($ambilDataAdmin) {
                $data = [
                    'id_admin' => $id_admin,
                    'nama' => $ambilDataAdmin['nama'],
                    'username' => $ambilDataAdmin['username'],
                    'password'=> $ambilDataAdmin['password'],
                    'level' => $ambilDataAdmin['level'],
                    'status' => $ambilDataAdmin['status'],
                
                ];

                $msg = [
                    'data' => view('Admin/VeditAdmin', $data)
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
            $id_admin = $this->request->getVar('id_admin');
            $nama = $this->request->getVar('nama');
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $level = $this->request->getVar('level');
            $status = $this->request->getVar('status');
     
            if (!empty($password)) {
                $password = md5($password);
            } else {
            // Jika password kosong, gunakan password lama
            $existingData = $this->AdminModel->find($id_admin);
            $password = $existingData['password'];
        }

            // Update data admin di database
            $this->AdminModel->update($id_admin, [
                'nama'=> $nama,
                'username' => $username,
                'password' => $password ?? null,  // Jika password kosong, tidak perlu di-update
                'level' => $level,
                'status' => $status,
            ]);
    
            // Kirimkan pesan sukses
            $msg = [
                'sukses' => 'Data Berhasil Diupdate'
            ];
            echo json_encode($msg);
        }
    }
   
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_admin = $this->request->getVar('id_admin');
            $this->AdminModel->delete($id_admin);

            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];
            echo json_encode($msg);
        }
    }

}
