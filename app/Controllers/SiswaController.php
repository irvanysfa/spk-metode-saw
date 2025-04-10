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

        $kelas = $this->request->getGet('kelas');
        $angkatan = $this->request->getGet('angkatan');

        $query = $siswaModel;

        // Tambahkan filter jika kelas dipilih
        if (!empty($kelas)) {
            $query = $query->where('kelas', $kelas);
        }

        // Tambahkan filter jika angkatan dipilih
        if (!empty($angkatan)) {
            $query = $query->where('tahun_angkatan', $angkatan);
        }

        $siswa = $query->findAll();

        // Ambil semua kriteria
        $kriteria = $kriteriaModel->findAll();

        // Ambil nilai tiap siswa
        foreach ($siswa as &$s) {
            $s['nilai'] = $nilaiModel->where('id_siswa', $s['id_siswa'])->findAll();
        }

        // Ambil daftar tahun angkatan unik dari database
        $angkatanList = $siswaModel->select('tahun_angkatan')->distinct()->findAll();

        return view('siswa/index', [
            'siswa' => $siswa,
            'kriteria' => $kriteria,
            'angkatanList' => $angkatanList, // untuk filter
        ]);
    }



    public function create()
    {
        return view('siswa/create');
    }

    public function store()
    {
        $model = new SiswaModel();
        $data = [
            'kode_alternatif' => $this->request->getPost('kode_alternatif'),
            'nama_siswa'  => $this->request->getPost('nama_siswa'),
            'kelas'       => $this->request->getPost('kelas'),
            'tahun_angkatan'  => $this->request->getPost('tahun_angkatan')
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
            'kode_alternatif' => $this->request->getPost('kode_alternatif'),
            'nama_siswa'  => $this->request->getPost('nama_siswa'),
            'kelas'       => $this->request->getPost('kelas'),
            'tahun_angkatan'  => $this->request->getPost('tahun_angkatan')
        ];
        $model->update($id, $data);
        return redirect()->to('/siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }


    public function delete($id)
    {
        $model = new SiswaModel();
        $hasilModel = new \App\Models\HasilModel(); // Gunakan model hasil

        // Cek apakah siswa masih ada di tabel hasil
        $cekHasil = $hasilModel->where('id_siswa', $id)->countAllResults();

        if ($cekHasil > 0) {
            session()->setFlashdata('error', 'Siswa tidak dapat dihapus karena masih terdaftar dalam hasil perhitungan. Mohon hapus data siswa dari hasil perhitungan terlebih dahulu');
            return redirect()->to('/siswa');
        }

        // Jika tidak ada di tabel hasil, lanjutkan proses hapus
        $model->delete($id);
        session()->setFlashdata('success', 'Data siswa berhasil dihapus!');
        return redirect()->to('/siswa');
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
