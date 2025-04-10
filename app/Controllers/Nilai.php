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
        $nilaiModel = new \App\Models\NilaiModel();
        $kriteriaModel = new \App\Models\KriteriaModel();
        $siswaModel = new \App\Models\SiswaModel();

        // Ambil input filter
        $id_kriteria = $this->request->getGet('kriteria');
        $nama_siswa = $this->request->getGet('search');
        $kelas = $this->request->getGet('kelas');
        $angkatan = $this->request->getGet('angkatan');

        $data['nilai'] = $nilaiModel->getFilteredNilaiFull($id_kriteria, $nama_siswa, $kelas, $angkatan);

        $data['kriteria'] = $kriteriaModel->findAll();
        $data['selected_kriteria'] = $id_kriteria;
        $data['search'] = $nama_siswa;
        $data['selected_kelas'] = $kelas;
        $data['selected_angkatan'] = $angkatan;

        // Ambil kelas unik dan angkatan unik dari siswa
        $data['kelasList'] = $siswaModel->distinct()->select('kelas')->orderBy('kelas')->findAll();
        $data['angkatanList'] = $siswaModel->distinct()->select('tahun_angkatan')->orderBy('tahun_angkatan', 'desc')->findAll();

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

    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        $kriteria = $this->request->getGet('kriteria');
        $kelas = $this->request->getGet('kelas');
        $angkatan = $this->request->getGet('angkatan');

        $model = new \App\Models\NilaiModel();

        $data = $model->getFilteredData($kriteria, $kelas, $angkatan, $keyword);
        return $this->response->setJSON($data);
    }
}
