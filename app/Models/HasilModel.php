<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilModel extends Model
{
    protected $table = 'hasil';
    protected $primaryKey = 'id_hasil';
    protected $allowedFields = ['id_siswa', 'total_nilai', 'ranking', 'kelas'];

    public function getHasilByKelas($kelas)
    {
        return $this->db->table('hasil')
            ->select('hasil.*, siswa.nama_siswa, siswa.kelas')
            ->join('siswa', 'siswa.id_siswa = hasil.id_siswa')
            ->where('hasil.kelas', $kelas)
            ->orderBy('hasil.ranking', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getKelas()
    {
        return $this->db->table('hasil')->distinct()->select('kelas')->get()->getResultArray();
    }
}
