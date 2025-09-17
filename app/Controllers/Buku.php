<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
    protected $BukuModel;

    public function __construct() {
        $this->BukuModel = new BukuModel();
    }

    public function index() 
    {
        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->BukuModel->getBuku()
        ];
        
        return view('buku/index', $data);
    }
    
    public function detail($idbuku) {
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->BukuModel->getBuku($idbuku)
        ];
        
        return view('buku/detail', $data);
    }
    
    public function tambah() {
        $data = [
            'title' => 'Form Tambah Data Buku',
            'validation' => \Config\Services::validation()
        ];
        
        return view('buku/tambah', $data);
    }

    public function simpan() {
        if(!$this->validate(
            [
                'judul' => [
                    'rules' => 'required',
                    'erors' => ['required' => '{field} harus di isi']
                ],  
                'sampul' => [
                    'rules' => 'uploaded[sampul]|max_size[sampul,10000]|is_image[sampul]|mime_in[sampul, image/jpg, image/jpeg, image/png]',    
                    'errors' => [
                        'uploaded' => 'Gambar Wajib Dipilih',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'File Wajib Gambar',
                        'mime_in' => 'Tipe File Gambar Tidak Sesuai'
                    ]
                ]
            ]
        ))

        $filesampul = $this->request->getFile('sampul');
        $filesampul->move('img');
        $nmsampul = $filesampul->getName();

        //simpan
        $this->BukuModel->save(
            [
                'judul' => $this->request->getVar('judul'),
                'pengarang' => $this->request->getVar('pengarang'),
                'penerbit' => $this->request->getVar('penerbit'),
                'tahun_terbit' => $this->request->getVar('tahun_terbit'),
                'sampul' => $nmsampul,
            ]
        );
        session()->setFlashdata('pesan', 'Data Berhasil ditambahkan');
        return redirect()->to('/buku');
    }

    public function hapus($idbuku) {
        $this->BukuModel->delete($idbuku);

        session()->setFlashdata('pesan', 'Data Berhasil Dimasukan');
        return redirect()->to('/buku');
    }

    public function ubah($idbuku) {
        $data = [
            'title' => 'Form Ubah Data Buku',
            'validation' => \Config\Services::validation(),
            'buku' => $this->BukuModel->getBuku($idbuku)
        ];

        return view('buku/ubah', $data);
    }

    public function update($idbuku) {
        if(!$this->validate(
            [
                'judul' => [
                    'rules' => 'required',
                    'erors' => ['required' => '{field} harus di isi']
                ],  
                'sampul' => [
                    'rules' => 'uploaded[sampul]|max_size[sampul,10000]|is_image[sampul]|mime_in[sampul, image/jpg, image/jpeg, image/png]',    
                    'errors' => [
                        'uploaded' => 'Gambar Wajib Dipilih',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'File Wajib Gambar',
                        'mime_in' => 'Tipe File Gambar Tidak Sesuai'
                    ]
                ]
            ]
        ))
        
        $filesampul = $this->request->getFile('sampul');
        // $nmsampul = $filesampul->getName();
        
        if($filesampul->getError() == 4) {
            $nmsampul = $this->request->getVar('sampulLama');
        } else {
            // $filesampul->move('img');
            $nmsampul = $filesampul -> getName();
            $filesampul->move('img', $nmsampul);
        }

        //simpan
        $this->BukuModel->save(
            [
                'id_buku' => $idbuku,
                'judul' => $this->request->getVar('judul'),
                'pengarang' => $this->request->getVar('pengarang'),
                'penerbit' => $this->request->getVar('penerbit'),
                'tahun_terbit' => $this->request->getVar('tahun_terbit'),
                'sampul' => $nmsampul,
            ]
        );
        session()->setFlashdata('pesan', 'Data Berhasil diubah');
        return redirect()->to('/buku/'. $idbuku)->withInput();
    }
}
