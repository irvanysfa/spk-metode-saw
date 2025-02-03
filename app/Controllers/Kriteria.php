<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use CodeIgniter\Controller;

class Kriteria extends Controller
{
    public function index()
    {
        $model = new KriteriaModel();
        $data['kriteria'] = $model->findAll();
        return view('kriteria/index', $data);
    }

    public function create()
    {
        return view('kriteria/create');
    }

    public function save()
    {
        $model = new KriteriaModel();

        $data = [
            'kode_kriteria'  => $this->request->getPost('kode_kriteria'),
            'nama_kriteria'  => $this->request->getPost('nama_kriteria'),
            'bobot'          => $this->request->getPost('bobot'),
            'sifat'          => $this->request->getPost('sifat')
        ];

        $model->insert($data);

        return redirect()->to('/kriteria')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    // Fungsi baru untuk menampilkan form edit
    public function edit($id)
    {
        $model = new KriteriaModel();
        $data['kriteria'] = $model->find($id);

        if (!$data['kriteria']) {
            return redirect()->to('/kriteria')->with('error', 'Data kriteria tidak ditemukan.');
        }

        return view('kriteria/edit', $data);
    }

    public function update($id)
    {
        $model = new KriteriaModel();

        $data = [
            'kode_kriteria'  => $this->request->getPost('kode_kriteria'),
            'nama_kriteria'  => $this->request->getPost('nama_kriteria'),
            'bobot'          => $this->request->getPost('bobot'),
            'sifat'          => $this->request->getPost('sifat')
        ];

        $model->update($id, $data);

        return redirect()->to('/kriteria')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new KriteriaModel();
        $model->delete($id);
        return redirect()->to('/kriteria')->with('success', 'Kriteria berhasil dihapus.');
    }
}
