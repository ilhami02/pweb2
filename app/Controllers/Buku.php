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
        $current = $this->request->getVar('page_buku') ? $this->request->getVar('page_buku'):1;
        $cari = $this->request->getVar('cari');
        if ($cari) {
            $buku = $this->BukuModel->findBuku($cari);
        } else {
            $buku = $this->BukuModel;
        }
        $data = [
            'title' => 'Daftar Buku',
            'buku' => $buku->paginate(2, 'buku'),
            'pager' => $buku->pager,
            'current' => $current,
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
        
        if($filesampul->getError() == 4) {
            //error handle error 4 (file not upload)
            $nmsampul = $this->request->getVar('sampulLama');
        } else {
            //remove old sampul img
            $bukuLama = $this->BukuModel->getBuku($idbuku);
            unlink('img/' . $bukuLama['sampul']);
            
            //add new img for sampul
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
