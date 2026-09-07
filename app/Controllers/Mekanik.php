<?php

namespace App\Controllers;
use App\Models\Mmekanik;
use CodeIgniter\Controller;

class Mekanik extends BaseController
{
    protected $MekanikModel;

    public function __construct()
    {
        $this->MekanikModel = new Mmekanik();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolmekanik');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('carimekanik');
            session()->set('carimekanik', $cari);
            redirect()->to('/Mekanik/index');
        } else {
            $cari = session()->get('carimekanik');
        }

        // Ambil data mekanik berdasarkan pencarian
        $Mekanik = $cari ? $this->MekanikModel->cariData($cari) : $this->MekanikModel;
        $noHalaman = $this->request->getVar('page_mekanik') ? $this->request->getVar('page_mekanik') : 1;

        // Kirimkan data ke view
        $data = [
            'Mekanik' => $Mekanik->paginate(10, 'mekanik'),
            'pager' => $this->MekanikModel->pager,
            'cari' => $cari
        ];

        return view('Mekanik/Vmekanik', $data);
    }


    public function formtambah()
{
    $msg = [
        'data' => view('Mekanik/VtambahMekanik')
    ];
    echo json_encode($msg);
}

    public function simpan()
{
    if ($this->request->isAJAX()) {
        // Ambil data dari form
        $nama_mekanik = $this->request->getPost('nama_mekanik');
         $no_hp    = $this->request->getPost('no_hp');
        $alamat = $this->request->getPost('alamat');
       

        // Validasi input sederhana
        if (empty($nama_mekanik) || empty($no_hp) || empty($alamat)) {
            $msg = [
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ];
            echo json_encode($msg);
            return;
        }
         $cekNama = $this->MekanikModel->where('nama_mekanik', $nama_mekanik)->first();
        if ($cekNama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Mekanik sudah digunakan!'
            ]);
        }
        // Siapkan data untuk disimpan
        $data = [
            'nama_mekanik' => $nama_mekanik,
            'no_hp'    => $no_hp,
              'alamat' => $alamat
        ];

        // Simpan ke database
        $this->MekanikModel->insert($data);

        // Kirim respons ke AJAX
        $msg = [
            'success' => true,
            'message' => 'Data Mekanik berhasil ditambahkan!'
        ];
        echo json_encode($msg);
    }
}


 public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_mekanik = $this->request->getPost('id_mekanik');
            $ambilDataMekanik = $this->MekanikModel->find($id_mekanik);
            
            if ($ambilDataMekanik) {
                $data = [
                    'id_mekanik' => $id_mekanik,
                    'nama_mekanik' => $ambilDataMekanik['nama_mekanik'],
                    'no_hp' => $ambilDataMekanik['no_hp'],
                   'alamat'=> $ambilDataMekanik['alamat'],
                   'status'=> $ambilDataMekanik['status'],
                
                ];

                $msg = [
                    'data' => view('Mekanik/VeditMekanik', $data)
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
            $id_mekanik = $this->request->getVar('id_mekanik');
            $nama_mekanik = $this->request->getVar('nama_mekanik');
            $no_hp = $this->request->getVar('no_hp');
            $alamat = $this->request->getVar('alamat');
            $status = $this->request->getVar('status');

            // Update data Mekanik di database
            $this->MekanikModel->update($id_mekanik, [
                'nama_mekanik' => $nama_mekanik, 
                'no_hp' => $no_hp,
                 'alamat' => $alamat , 
                 'status'=> $status,
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
            $id_mekanik = $this->request->getVar('id_mekanik');
            $this->MekanikModel->delete($id_mekanik);

            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];
            echo json_encode($msg);
        }
    }
public function laporan()
{
    $dataMekanik = $this->MekanikModel->findAll();
    $username = session()->get('username');
    $data = [
        'title' => 'Laporan Data Mekanik',
        'dataMekanik' => $dataMekanik,
        'username' => session()->get('nama'),
    ];

    return view('Mekanik/laporan_mekanik', $data);
}

}
