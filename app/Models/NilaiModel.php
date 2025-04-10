<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['id_siswa', 'id_kriteria', 'nilai'];

    public function getAllNilai()
    {
        return $this->select('nilai.*, siswa.nama_siswa, kriteria.nama_kriteria')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria')
            ->findAll();
    }

    public function saveUniqueNilai($id_siswa, $id_kriteria, $nilai)
    {
        $existing = $this->where('id_siswa', $id_siswa)
            ->where('id_kriteria', $id_kriteria)
            ->first();

        if ($existing) {
            // Jika nilai sudah ada, kembalikan false agar bisa ditangani di controller
            return false;
        } else {
            // Jika belum ada, insert data baru
            return $this->insert([
                'id_siswa' => $id_siswa,
                'id_kriteria' => $id_kriteria,
                'nilai' => $nilai
            ]);
        }
    }

    public function isNilaiExist($id_siswa, $id_kriteria)
    {
        return $this->where('id_siswa', $id_siswa)
            ->where('id_kriteria', $id_kriteria)
            ->countAllResults() > 0;
    }

    public function getNilaiWithSiswaKriteria()
    {
        return $this->select('nilai.id_siswa, nilai.id_kriteria, nilai.nilai, kriteria.nama_kriteria')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria')
            ->orderBy('nilai.id_siswa, nilai.id_kriteria')
            ->findAll();
    }

    public function getNilaiByKriteria($id_kriteria)
    {
        return $this->select('nilai.*, siswa.nama_siswa, kriteria.nama_kriteria')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria')
            ->where('nilai.id_kriteria', $id_kriteria)
            ->findAll();
    }

    public function getFilteredNilai($id_kriteria = null, $nama_siswa = null)
    {
        $builder = $this->select('nilai.*, siswa.nama_siswa, kriteria.nama_kriteria')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria');

        if (!empty($id_kriteria)) {
            $builder->where('nilai.id_kriteria', $id_kriteria);
        }

        if (!empty($nama_siswa)) {
            $builder->like('siswa.nama_siswa', $nama_siswa);
        }

        return $builder->findAll();
    }

    public function getFilteredNilaiFull($id_kriteria = null, $nama_siswa = null, $kelas = null, $angkatan = null)
    {
        $builder = $this->select('nilai.*, siswa.nama_siswa, siswa.kelas, siswa.tahun_angkatan, kriteria.nama_kriteria')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria');

        if (!empty($id_kriteria)) {
            $builder->where('nilai.id_kriteria', $id_kriteria);
        }

        if (!empty($nama_siswa)) {
            $builder->like('siswa.nama_siswa', $nama_siswa);
        }

        if (!empty($kelas)) {
            $builder->where('siswa.kelas', $kelas);
        }

        if (!empty($angkatan)) {
            $builder->where('siswa.tahun_angkatan', $angkatan);
        }

        return $builder->findAll();
    }
    public function getFilteredData($id_kriteria = null, $kelas = null, $angkatan = null, $keyword = null)
    {
        $builder = $this->select('nilai.*, siswa.nama_siswa, kriteria.nama_kriteria')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria');

        if ($id_kriteria) {
            $builder->where('nilai.id_kriteria', $id_kriteria);
        }

        if ($kelas) {
            $builder->where('siswa.kelas', $kelas);
        }

        if ($angkatan) {
            $builder->where('siswa.tahun_angkatan', $angkatan);
        }

        if ($keyword) {
            $builder->like('siswa.nama_siswa', $keyword);
        }

        return $builder->findAll();
    }
}
