<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganModel extends Model
{
    protected $table = 'nilai';

    public function getKelas()
    {
        return $this->db->table('siswa')->distinct()->select('kelas')->get()->getResultArray();
    }

    public function getSiswaByKelas($kelas)
    {
        return $this->db->table('siswa')->where('kelas', $kelas)->get()->getResultArray();
    }

    public function getKriteria()
    {
        return $this->db->table('kriteria')->get()->getResultArray();
    }

    public function getNilaiWithSiswaKriteria($kelas)
    {
        return $this->db->table('nilai')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria')
            ->where('siswa.kelas', $kelas)
            ->select('nilai.*, siswa.nama_siswa, siswa.kelas, kriteria.sifat, kriteria.bobot')
            ->get()->getResultArray();
    }

    public function getMaxMinNilai($kelas)
    {
        $query = $this->db->query("
            SELECT kriteria.id_kriteria, 
                   MAX(nilai.nilai) AS max, 
                   MIN(nilai.nilai) AS min 
            FROM nilai
            JOIN siswa ON siswa.id_siswa = nilai.id_siswa
            JOIN kriteria ON kriteria.id_kriteria = nilai.id_kriteria
            WHERE siswa.kelas = ?
            GROUP BY kriteria.id_kriteria
        ", [$kelas]);

        $maxMinNilai = [];
        foreach ($query->getResultArray() as $row) {
            $maxMinNilai[$row['id_kriteria']] = [
                'max' => $row['max'],
                'min' => $row['min']
            ];
        }
        return $maxMinNilai;
    }

    public function hitungNormalisasi($nilai, $kelas)
    {
        $maxMinNilai = $this->getMaxMinNilai($kelas);
        $normalisasi = [];

        foreach ($nilai as $n) {
            $id_siswa = $n['id_siswa'];
            $id_kriteria = $n['id_kriteria'];
            $nilai_siswa = $n['nilai'];
            $sifat = $n['sifat'];

            $max = $maxMinNilai[$id_kriteria]['max'] ?? 1;
            $min = $maxMinNilai[$id_kriteria]['min'] ?? 1;

            if ($sifat == 'benefit') {
                $normalisasi[$id_siswa][$id_kriteria] = ($max > 0) ? round($nilai_siswa / $max, 4) : 0;
            } else {
                $normalisasi[$id_siswa][$id_kriteria] = ($nilai_siswa > 0) ? round($min / $nilai_siswa, 4) : 0;
            }
        }

        return $normalisasi;
    }

    public function getBobotNormalisasi()
    {
        $kriteria = $this->getKriteria();
        $totalBobot = array_sum(array_column($kriteria, 'bobot'));

        foreach ($kriteria as &$k) {
            $k['bobot_normalisasi'] = $totalBobot > 0 ? round($k['bobot'] / $totalBobot, 4) : 0;
        }

        return $kriteria;
    }

    public function hitungTotalNilai($normalisasi)
    {
        $bobotKriteria = $this->getBobotNormalisasi();
        $bobot = array_column($bobotKriteria, 'bobot_normalisasi', 'id_kriteria');
        $totalNilai = [];

        foreach ($normalisasi as $id_siswa => $nilai_kriteria) {
            $total = 0;
            foreach ($nilai_kriteria as $id_kriteria => $nilai) {
                $total += $nilai * ($bobot[$id_kriteria] ?? 0);
            }
            $totalNilai[$id_siswa] = round($total, 4);
        }

        return $totalNilai;
    }

    public function simpanHasil($hasil, $kelas)
    {
        $this->db->table('hasil')->where('kelas', $kelas)->delete();
        $data = [];

        foreach ($hasil as $id_siswa => $total_nilai) {
            $data[] = [
                'id_siswa' => $id_siswa,
                'total_nilai' => $total_nilai,
                'kelas' => $kelas
            ];
        }

        usort($data, fn($a, $b) => $b['total_nilai'] <=> $a['total_nilai']);

        foreach ($data as $ranking => &$row) {
            $row['ranking'] = $ranking + 1;
        }

        if (!empty($data)) {
            $this->db->table('hasil')->insertBatch($data);
        }
    }
}
