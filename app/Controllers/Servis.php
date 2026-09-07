<?php

namespace App\Controllers;
use App\Models\Mservis;
use CodeIgniter\Controller;

class Servis extends BaseController
{
    protected $servisModel;

    public function __construct()
    {
        $this->servisModel = new Mservis();
        helper(['form', 'url']);
    }

  public function index()
    {
        // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolservis');

        if (isset($tombolCari)) {
            $cari = $this->request->getPost('cariservis');
            session()->set('cariservis', $cari);
            redirect()->to('/Servis/index');
        } else {
            $cari = session()->get('cariservis');
        }

        // Ambil data servis berdasarkan pencarian
        $servis = $cari ? $this->servisModel->cariData($cari) : $this->servisModel;
        $noHalaman = $this->request->getVar('page_servis') ? $this->request->getVar('page_servis') : 1;

        // Kirimkan data ke view
        $data = [
            'servis' => $servis->paginate(10, 'servis'),
            'pager' => $this->servisModel->pager,
            'cari' => $cari
        ];

        return view('Servis/Vservis', $data);
    }

    public function formtambah()
{
    $msg = [
        'data' => view('servis/VtambahServis')
    ];
    echo json_encode($msg);
}

    public function simpan()
{
    if ($this->request->isAJAX()) {
        // Ambil data dari form
        $nama_servis = $this->request->getPost('nama_servis');
        $deskripsi = $this->request->getPost('deskripsi');
         $harga_servis    = $this->request->getPost('harga_servis');
       

        // Validasi input sederhana
        if (empty($nama_servis) || empty($harga_servis) || empty($deskripsi)) {
            $msg = [
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ];
            echo json_encode($msg);
            return;
        }
         $cekNama = $this->servisModel->where('nama_servis', $nama_servis)->first();
        if ($cekNama) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nama Servis sudah digunakan!'
            ]);
        }
        // Siapkan data untuk disimpan
        $data = [
            'nama_servis' => $nama_servis,
            'deskripsi'=> $deskripsi,
            'harga_servis'    => $harga_servis
        ];

        // Simpan ke database
        $this->servisModel->insert($data);

        // Kirim respons ke AJAX
        $msg = [
            'success' => true,
            'message' => 'Data servis berhasil ditambahkan!'
        ];
        echo json_encode($msg);
    }
}


 public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_servis = $this->request->getPost('id_servis');
            $ambilDataservis = $this->servisModel->find($id_servis);
            
            if ($ambilDataservis) {
                $data = [
                    'id_servis' => $id_servis,
                    'nama_servis' => $ambilDataservis['nama_servis'],
                    'deskripsi'=> $ambilDataservis['deskripsi'],
                    'harga_servis' => $ambilDataservis['harga_servis'],
                ];

                $msg = [
                    'data' => view('servis/VeditServis', $data)
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
            $id_servis = $this->request->getVar('id_servis');
            $nama_servis = $this->request->getVar('nama_servis');
            $deskripsi = $this->request->getVar('deskripsi');
            $harga_servis = $this->request->getVar('harga_servis');

            // Update data servis di database
            $this->servisModel->update($id_servis, [
                'nama_servis' => $nama_servis, 
                'deskripsi'=> $deskripsi,
                'harga_servis' => $harga_servis,
                 
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
            $id_servis = $this->request->getVar('id_servis');
            $this->servisModel->delete($id_servis);

            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];
            echo json_encode($msg);
        }
    }

public function laporan()
{
    $dataServis = $this->servisModel->findAll();
    $username = session()->get('username');
    $data = [
        'title' => 'Laporan Data Servis',
        'dataServis' => $dataServis,
        'username' => session()->get('nama'),
    ];

    return view('Servis/laporan_servis', $data);
}

}
