<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilModel extends Model
{
    protected $table = 'hasil';
    protected $primaryKey = 'id_hasil';
    protected $allowedFields = ['id_siswa', 'total_nilai', 'ranking', 'kelas'];

    public function getHasilByTahun($tahun_angkatan)
    {
        return $this->db->table('hasil')
            ->select('hasil.*, siswa.nama_siswa, siswa.tahun_angkatan')
            ->join('siswa', 'siswa.id_siswa = hasil.id_siswa')
            ->where('siswa.tahun_angkatan', $tahun_angkatan)
            ->orderBy('hasil.ranking', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getHasilByTahunAngkatan($tahunAngkatan)
    {
        return $this->db->table('hasil')
            ->select('hasil.*, siswa.nama_siswa, siswa.kelas, siswa.tahun_angkatan')
            ->join('siswa', 'siswa.id_siswa = hasil.id_siswa')
            ->where('siswa.tahun_angkatan', $tahunAngkatan)
            ->orderBy('hasil.ranking', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getTahunAngkatan()
    {
        return $this->db->table('siswa')->distinct()->select('tahun_angkatan')->get()->getResultArray();
    }

    public function deleteHasilByTahun($tahun_angkatan)
    {
        // Cari semua ID siswa berdasarkan tahun angkatan
        $siswa = $this->db->table('siswa')
            ->select('id_siswa')
            ->where('tahun_angkatan', $tahun_angkatan)
            ->get()
            ->getResultArray();

        if (!empty($siswa)) {
            $idSiswa = array_column($siswa, 'id_siswa');

            // Hapus semua hasil yang id_siswa-nya termasuk yang ditemukan
            return $this->whereIn('id_siswa', $idSiswa)->delete();
        }

        return false; // Kalau tidak ada siswa
    }
}
