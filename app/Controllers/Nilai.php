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
        $kriteriaModel = new KriteriaModel();
    
        // Ambil parameter kriteria dari GET request
        $id_kriteria = $this->request->getGet('kriteria');
    
        // Ambil daftar semua kriteria untuk dropdown
        $kriteriaList = $kriteriaModel->findAll();
    
        // Ambil data nilai berdasarkan kriteria (jika ada filter)
        if ($id_kriteria) {
            $data['nilai'] = $nilaiModel->getNilaiByKriteria($id_kriteria);
        } else {
            $data['nilai'] = $nilaiModel->getAllNilai();
        }
    
        $data['kriteria'] = $kriteriaList;
        $data['selected_kriteria'] = $id_kriteria; // Menyimpan pilihan kriteria saat ini di dropdown
    
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
    
        // Ambil data nilai lama
        $nilaiLama = $nilaiModel->find($id);
        if (!$nilaiLama) {
            return redirect()->to('/nilai')->with('error', 'Data nilai tidak ditemukan.');
        }
    
        // Ambil input baru dari form
        $nilaiBaru = $this->request->getPost('nilai');
    
        $data = [
            'id_siswa' => $nilaiLama['id_siswa'], // Tetap menggunakan id_siswa yang lama
            'id_kriteria' => $nilaiLama['id_kriteria'], // Tetap menggunakan id_kriteria yang lama
            'nilai' => $nilaiBaru
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
