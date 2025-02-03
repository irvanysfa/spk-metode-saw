<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $allowedFields = ['nomor_absen', 'nama_siswa', 'kelas']; // Tambahkan nomor_absen
    
    public function getAllSiswa()
    {
        return $this->findAll();
    }
    public function getSiswaByKelas($kelas)
    {
        return $this->where('kelas', $kelas)->findAll();
    }
    
    public function getAllSiswaWithNilai()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('siswa');
        $builder->select('siswa.*, nilai.id_kriteria, nilai.nilai, kriteria.nama_kriteria');
        $builder->join('nilai', 'nilai.id_siswa = siswa.id_siswa', 'left');
        $builder->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria', 'left');

        $query = $builder->get()->getResultArray();

        // Susun data agar setiap siswa memiliki daftar nilai per kriteria
        $data = [];
        foreach ($query as $row) {
            $id_siswa = $row['id_siswa'];

            if (!isset($data[$id_siswa])) {
                $data[$id_siswa] = [
                    'id_siswa' => $row['id_siswa'],
                    'nomor_absen' => $row['nomor_absen'],
                    'nama_siswa' => $row['nama_siswa'],
                    'kelas' => $row['kelas'],
                    'nilai' => []
                ];
            }

            if ($row['id_kriteria'] !== null) { // Cek jika ada nilai
                $data[$id_siswa]['nilai'][] = [
                    'id_kriteria' => $row['id_kriteria'],
                    'nama_kriteria' => $row['nama_kriteria'],
                    'nilai' => $row['nilai']
                ];
            }
        }

        return array_values($data); // Reset indeks array
    }
}
