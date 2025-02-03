<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\KriteriaModel;
use App\Models\NilaiModel;
use CodeIgniter\Controller;

class SiswaController extends Controller
{
    public function index()
    {
        $siswaModel = new SiswaModel();
        $kriteriaModel = new KriteriaModel();
        $nilaiModel = new NilaiModel();
    
        $kelas = $this->request->getGet('kelas'); // Ambil kelas dari parameter GET
        if ($kelas && in_array($kelas, ['1', '2', '3', '4', '5', '6'])) {
            $data['siswa'] = $siswaModel->getSiswaByKelas($kelas);
        } else {
            $data['siswa'] = $siswaModel->findAll(); // Jika tidak ada filter kelas, tampilkan semua
        }
    
        $data['kriteria'] = $kriteriaModel->findAll();
    
        foreach ($data['siswa'] as &$siswa) {
            $siswa['nilai'] = $nilaiModel->where('id_siswa', $siswa['id_siswa'])->findAll();
        }
    
        return view('siswa/index', $data);
    }
    

    public function create()
    {
        return view('siswa/create');
    }

    public function store()
    {
        $model = new SiswaModel();
        $data = [
            'nomor_absen' => $this->request->getPost('nomor_absen'),
            'nama_siswa'  => $this->request->getPost('nama_siswa'),
            'kelas'       => $this->request->getPost('kelas')
        ];
        $model->insert($data);
        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil ditambahkan!');
    }
    

    public function edit($id)
    {
        $model = new SiswaModel();
        $data['siswa'] = $model->find($id);
        return view('siswa/edit', $data);
    }

    public function update($id)
    {
        $model = new SiswaModel();
        $data = [
            'nomor_absen' => $this->request->getPost('nomor_absen'),
            'nama_siswa'  => $this->request->getPost('nama_siswa'),
            'kelas'       => $this->request->getPost('kelas')
        ];
        $model->update($id, $data);
        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }
    

    public function delete($id)
    {
        $model = new SiswaModel();
        $model->delete($id);
        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil dihapus!');
    }

    // ✨ Fungsi Baru: Edit Nilai Siswa
    public function editNilai($id_siswa)
    {
        $siswaModel = new SiswaModel();
        $kriteriaModel = new KriteriaModel();
        $nilaiModel = new NilaiModel();

        $data = [
            'siswa' => $siswaModel->find($id_siswa),
            'kriteria' => $kriteriaModel->findAll(),
            'nilai' => $nilaiModel->where('id_siswa', $id_siswa)->findAll()
        ];

        return view('siswa/edit_nilai', $data);
    }

    // ✨ Fungsi Baru: Update Nilai Siswa
    public function updateNilai()
    {
        $nilaiModel = new NilaiModel();
        $id_siswa = $this->request->getPost('id_siswa');
        $id_kriteria = $this->request->getPost('id_kriteria');
        $nilai = $this->request->getPost('nilai');

        foreach ($id_kriteria as $index => $kriteria) {
            $existing = $nilaiModel->where('id_siswa', $id_siswa)
                                   ->where('id_kriteria', $kriteria)
                                   ->first();

            if ($existing) {
                $nilaiModel->update($existing['id_nilai'], ['nilai' => $nilai[$index]]);
            } else {
                $nilaiModel->insert([
                    'id_siswa' => $id_siswa,
                    'id_kriteria' => $kriteria,
                    'nilai' => $nilai[$index]
                ]);
            }
        }

        return redirect()->to('/siswa')->with('success', 'Nilai berhasil diperbarui.');
    }
}
