<?php
namespace App\Controllers;
use App\Models\Msparepart;
use CodeIgniter\Controller;
class Sparepart extends BaseController
{    protected $SparepartModel;
     public function __construct()
    {
        $this->SparepartModel = new Msparepart();
        helper(['form', 'url']);
    }
  public function index()
    {   // Ambil data dari form pencarian
        $tombolCari = $this->request->getPost('tombolSparepart');
        if (isset($tombolCari)) {
            $cari = $this->request->getPost('cariSparepart');
            session()->set('cariSparepart', $cari);
            redirect()->to('/Sparepart/index');
        } else {
            $cari = session()->get('cariSparepart');
        }
        // Ambil data Sparepart berdasarkan pencarian
        $Sparepart = $cari ? $this->SparepartModel->cariData($cari) : $this->SparepartModel;
        $noHalaman = $this->request->getVar('page_Sparepart') ? $this->request->getVar('page_Sparepart') : 1;
        // Kirimkan data ke view
        $data = [
            'Sparepart' => $Sparepart->paginate(10, 'sparepart'),
            'pager' => $this->SparepartModel->pager,
            'cari' => $cari];
        return view('Sparepart/VSparepart', $data);
    }
    public function formtambah()
{
    $msg = [
        'data' => view('Sparepart/VtambahSparepart')
    ];
    echo json_encode($msg);
}
    public function simpan()
{
    if ($this->request->isAJAX()) {
        // Ambil data dari form
            $nama_sparepart = $this->request->getPost('nama_sparepart');
            $no_parts = $this->request->getPost('no_parts');
            $stok    = $this->request->getPost('stok');
            $satuan    = $this->request->getPost('satuan');
            $harga_beli    = $this->request->getPost('harga_beli');
            $harga_jual    = $this->request->getPost('harga_jual');
        // Validasi input sederhana
        if (empty($nama_sparepart) || empty($no_parts) || empty($satuan) || empty($harga_beli) || empty($harga_jual) ) {
            $msg = [
                'success' => false,
                'message' => 'Semua field wajib diisi!'
            ];
            echo json_encode($msg);
            return;}
            $cekNoParts = $this->SparepartModel->where('no_parts', $no_parts)->first();
        if ($cekNoParts) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No Parts sudah digunakan!'
            ]);
        }
        // Handle foto upload
        $namaFoto = '';
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/sparepart', $namaFoto);
        }

        // Siapkan data untuk disimpan
        $data = [
            'nama_sparepart' => $nama_sparepart,
            'no_parts'  => $no_parts,
            'foto'      => $namaFoto,
            'stok'      => $stok,
            'satuan'    => $satuan,
            'harga_beli' => $harga_beli,
            'harga_jual' => $harga_jual
        ];
        // Simpan ke database
        $this->SparepartModel->insert($data);

        // Kirim respons ke AJAX
        $msg = [
            'success' => true,
            'message' => 'Data Sparepart berhasil ditambahkan!'
        ];
        echo json_encode($msg);
    }}
 public function formEdit()
    {
        if ($this->request->isAJAX()) {
            $id_sparepart = $this->request->getPost('id_sparepart');
            $ambilDataSparepart = $this->SparepartModel->find($id_sparepart);
            
            if ($ambilDataSparepart) {
                $data = [
                    'id_sparepart' => $id_sparepart,
                    'nama_sparepart' => $ambilDataSparepart['nama_sparepart'],
                    'no_parts' => $ambilDataSparepart['no_parts'],
                    'foto' => $ambilDataSparepart['foto'],
                    'stok'=> $ambilDataSparepart['stok'],
                    'satuan' => $ambilDataSparepart['satuan'],
                    'harga_beli' => $ambilDataSparepart['harga_beli'],
                    'harga_jual' => $ambilDataSparepart['harga_jual'],
                ];
                $msg = [
                    'data' => view('Sparepart/VeditSparepart', $data)
                ];
            } else {
                $msg = [
                    'error' => 'Data tidak ditemukan'
                ];
            } 
            echo json_encode($msg);
        }}
public function updateData()
    {
        if ($this->request->isAJAX()) {
            $id_sparepart = $this->request->getVar('id_sparepart');
            $nama_sparepart = $this->request->getVar('nama_sparepart');
            $no_parts = $this->request->getVar('no_parts');
            $stok = $this->request->getVar('stok');
            $satuan = $this->request->getVar('satuan');
            $harga_beli = $this->request->getVar('harga_beli');
            $harga_jual = $this->request->getVar('harga_jual');
            $fotoLama = $this->request->getVar('fotoLama');

            // Validasi no_parts unik
            $cekNoParts = $this->SparepartModel->where('no_parts', $no_parts)
                                               ->where('id_sparepart !=', $id_sparepart)
                                               ->first();
            if ($cekNoParts) {
                return $this->response->setJSON([
                    'error' => 'No Parts sudah digunakan oleh sparepart lain!'
                ]);
            }

            // Handle foto upload
            $namaFoto = $fotoLama;
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                // Hapus foto lama jika ada
                if ($fotoLama && file_exists(FCPATH . 'uploads/sparepart/' . $fotoLama)) {
                    unlink(FCPATH . 'uploads/sparepart/' . $fotoLama);
                }
                $namaFoto = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads/sparepart', $namaFoto);
            }

            // Update data Sparepart di database
            $this->SparepartModel->update($id_sparepart, [
                'nama_sparepart' => $nama_sparepart, 
                'no_parts' => $no_parts,
                'foto' => $namaFoto,
                'stok' => $stok,
                'satuan' => $satuan,
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_jual,   
            ]);
            // Kirimkan pesan sukses
            $msg = [
                'sukses' => 'Data Berhasil Diupdate'
            ];
            echo json_encode($msg);
        }}
    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $id_sparepart = $this->request->getVar('id_sparepart');
            $this->SparepartModel->delete($id_sparepart);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus'
            ];
            echo json_encode($msg);
        }}
        public function laporan()
{
    $dataSparepart = $this->SparepartModel->findAll();
    $username = session()->get('username');
    $data = [
        'title' => 'Laporan Data Sparepart',
        'dataSparepart' => $dataSparepart,
        'username' => session()->get('nama'),
    ];

    return view('Sparepart/laporan_sparepart', $data);
}
}
