<?php

namespace App\Controllers;

use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\KriteriaModel;
use CodeIgniter\Controller;

class Nilai extends Controller
{
    public function index()
    {
        $nilaiModel = new NilaiModel();
        $data['nilai'] = $nilaiModel->getAllNilai();

        return view('nilai/index', $data);
    }

    public function create()
    {
        $siswaModel = new SiswaModel();
        $kriteriaModel = new KriteriaModel();

        $data = [
            'siswa' => $siswaModel->findAll(),
            'kriteria' => $kriteriaModel->findAll()
        ];

        return view('nilai/create', $data);
    }

    public function store()
    {
        $model = new NilaiModel();

        $id_siswa = $this->request->getPost('id_siswa');
        $id_kriteria = $this->request->getPost('id_kriteria');
        $nilai = $this->request->getPost('nilai');

        // Cek apakah nilai sudah ada
        if ($model->isNilaiExist($id_siswa, $id_kriteria)) {
            return redirect()->to('/nilai')->with('error', 'Nilai untuk kriteria ini sudah ada!');
        }

        // Jika belum ada, tambahkan nilai baru
        $model->insert([
            'id_siswa' => $id_siswa,
            'id_kriteria' => $id_kriteria,
            'nilai' => $nilai
        ]);

        return redirect()->to('/nilai')->with('success', 'Nilai berhasil ditambahkan!');
    }



    public function edit($id)
    {
        $nilaiModel = new NilaiModel();
        $siswaModel = new SiswaModel();
        $kriteriaModel = new KriteriaModel();

        $data = [
            'nilai' => $nilaiModel->find($id),
            'siswa' => $siswaModel->findAll(),
            'kriteria' => $kriteriaModel->findAll()
        ];

        return view('nilai/edit', $data);
    }

    public function update($id)
    {
        $nilaiModel = new NilaiModel();
        $data = [
            'id_siswa' => $this->request->getPost('id_siswa'),
            'id_kriteria' => $this->request->getPost('id_kriteria'),
            'nilai' => $this->request->getPost('nilai')
        ];

        $nilaiModel->update($id, $data);
        return redirect()->to('/nilai')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function delete($id)
    {
        $nilaiModel = new NilaiModel();
        $nilaiModel->delete($id);
        return redirect()->to('/nilai')->with('success', 'Nilai berhasil dihapus.');
    }
}
