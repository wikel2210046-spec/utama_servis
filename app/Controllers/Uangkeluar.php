<?php
namespace App\Controllers;
use App\Models\Muangkeluar;
use CodeIgniter\Controller;

class Uangkeluar extends BaseController
{
    protected $uangKeluarModel;

    public function __construct()
    {
        $this->uangKeluarModel = new Muangkeluar();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolUangkeluar');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('cariUangkeluar');
            session()->set('cariUangkeluar', $cari);
            redirect()->to('/Uangkeluar/index');
        } else {
            $cari = session()->get('cariUangkeluar');
        }
        
        $uang_keluar = $cari ? $this->uangKeluarModel->cariData($cari) : $this->uangKeluarModel;
        $noHalaman = $this->request->getVar('page_uang_keluar') ? $this->request->getVar('page_uang_keluar') : 1;

        $data = [
            'uang_keluar' => $uang_keluar->paginate(10, 'uang_keluar'),
            'pager' => $this->uangKeluarModel->pager,
            'cari' => $cari,
            'noHalaman' => $noHalaman
        ];
        return view('Uangkeluar/Vuangkeluar', $data);
    }

    public function formtambah()
    {
        $msg = [
            'data' => view('Uangkeluar/VtambahUangkeluar')
        ];
        echo json_encode($msg);
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $tanggal = $this->request->getPost('tanggal');
            $jenis_pengeluaran = $this->request->getPost('jenis_pengeluaran');
            $jumlah = $this->request->getPost('jumlah');
            $keterangan = $this->request->getPost('keterangan');

            if (empty($tanggal) || empty($jenis_pengeluaran) || empty($jumlah)) {
                $msg = [
                    'success' => false,
                    'message' => 'Tanggal, Jenis Pengeluaran, dan Jumlah wajib diisi!'
                ];
                echo json_encode($msg);
                return;
            }

            $data = [
                'tanggal' => $tanggal,
                'jenis_pengeluaran' => $jenis_pengeluaran,
                'jumlah' => $jumlah,
                'keterangan' => $keterangan
            ];

            $this->uangKeluarModel->insert($data);

            $msg = [
                'success' => true,
                'message' => 'Data Uang Keluar berhasil ditambahkan!'
            ];
            echo json_encode($msg);
        }
    }

    public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_uang_keluar = $this->request->getPost('id_uang_keluar');
            $ambilData = $this->uangKeluarModel->find($id_uang_keluar);
            
            if ($ambilData) {
                $data = [
                    'id_uang_keluar' => $id_uang_keluar,
                    'tanggal' => $ambilData['tanggal'],
                    'jenis_pengeluaran' => $ambilData['jenis_pengeluaran'],
                    'jumlah' => $ambilData['jumlah'],
                    'keterangan' => $ambilData['keterangan']
                ];
                $msg = [
                    'data' => view('Uangkeluar/VeditUangkeluar', $data)
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
            $id_uang_keluar = $this->request->getVar('id_uang_keluar');
            $tanggal = $this->request->getVar('tanggal');
            $jenis_pengeluaran = $this->request->getVar('jenis_pengeluaran');
            $jumlah = $this->request->getVar('jumlah');
            $keterangan = $this->request->getVar('keterangan');

            $this->uangKeluarModel->update($id_uang_keluar, [
                'tanggal' => $tanggal,
                'jenis_pengeluaran' => $jenis_pengeluaran,
                'jumlah' => $jumlah,
                'keterangan' => $keterangan
            ]);

            $msg = [
                'sukses' => 'Data Berhasil Diupdate'
            ];
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_uang_keluar = $this->request->getVar('id_uang_keluar');
            $this->uangKeluarModel->delete($id_uang_keluar);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];
            echo json_encode($msg);
        }
    }
}
