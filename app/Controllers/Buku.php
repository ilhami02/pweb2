<?php

namespace App\Controllers;

use App\Models\BukuModel;

class Buku extends BaseController
{
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
        
        return view('buku/detail', $data);
    }

    public function simpan() {
        if(!$this->validate(
            [
                'judul' => [
                    'rules' => 'required',
                    'erors' => ['required' => '{field} harus di isi']
                ]
            ]
        )) {
            $validation = \Config\Service::validation();
            return redirect()->to('buku/tambah') -> withInput() -> with('validation', $validation);
        }
        $this->BukuModel->save(
            [
                'judul' => $this->request-getVar('judul'),
                'pengarang' => $this->request-getVar('pengarang'),
                'penerbit' => $this->request-getVar('penerbit'),
                'tahun_terbit' => $this->request-getVar('tahun_terbit'),
                'sampul' => $this->request-getVar('sampul'),
            ]
        );
        session()->setFlashdata('pesan', 'Data Berhasil ditambahkan');
        return redirect()->to('/buku');
    }
}
