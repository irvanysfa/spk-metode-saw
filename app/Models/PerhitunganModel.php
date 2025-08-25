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

    public function getKriteriaByTipe($tipe)
    {
        return $this->db->table('kriteria')->where('tipe_kriteria', $tipe)->get()->getResultArray();
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
    public function getKelasByIdSiswa($id_siswa)
    {
        return $this->db->table('siswa')
            ->where('id_siswa', $id_siswa)
            ->get()
            ->getRow('kelas');
    }

    public function getTahunAngkatan()
    {
        return $this->db->table('siswa')->distinct()->select('tahun_angkatan')->get()->getResultArray();
    }

    public function getSiswaByAngkatan($angkatan)
    {
        return $this->db->table('siswa')->where('tahun_angkatan', $angkatan)->get()->getResultArray();
    }

    public function getNilaiWithSiswaKriteriaByAngkatan($angkatan)
    {
        return $this->db->table('nilai')
            ->join('siswa', 'siswa.id_siswa = nilai.id_siswa')
            ->join('kriteria', 'kriteria.id_kriteria = nilai.id_kriteria')
            ->where('siswa.tahun_angkatan', $angkatan)
            ->select('nilai.*, siswa.nama_siswa, siswa.tahun_angkatan, kriteria.sifat, kriteria.bobot')
            ->get()->getResultArray();
    }
    public function getHasilByAngkatan($angkatan)
    {
        return $this->db->table('hasil')
            ->where('tahun_angkatan', $angkatan)
            ->get()
            ->getResultArray();
    }

    public function getMaxMinNilaiByAngkatan($angkatan)
    {
        $query = $this->db->query("
        SELECT kriteria.id_kriteria, 
               kriteria.kode_kriteria, 
               MAX(nilai.nilai) AS max, 
               MIN(nilai.nilai) AS min 
        FROM nilai
        JOIN siswa ON siswa.id_siswa = nilai.id_siswa
        JOIN kriteria ON kriteria.id_kriteria = nilai.id_kriteria
        WHERE siswa.tahun_angkatan = ?
        GROUP BY kriteria.id_kriteria, kriteria.kode_kriteria
    ", [$angkatan]);

        $maxMinNilai = [];
        foreach ($query->getResultArray() as $row) {
            $maxMinNilai[$row['id_kriteria']] = [
                'kode_kriteria' => $row['kode_kriteria'],
                'max' => $row['max'],
                'min' => $row['min']
            ];
        }
        return $maxMinNilai;
    }

    public function hitungNormalisasi($nilai, $angkatan)
    {
        $maxMinNilai = $this->getMaxMinNilaiByAngkatan($angkatan);
        $normalisasi = [];

        // Cek apakah ada nilai 0 untuk setiap kriteria (sekali saja di awal)
        $cekNolPerKriteria = [];
        foreach ($nilai as $n) {
            $id_kriteria = $n['id_kriteria'];
            if (!isset($cekNolPerKriteria[$id_kriteria])) {
                $cekNolPerKriteria[$id_kriteria] = false;
            }
            if ($n['nilai'] == 0) {
                $cekNolPerKriteria[$id_kriteria] = true;
            }
        }

        foreach ($nilai as $n) {
            $id_siswa = $n['id_siswa'];
            $id_kriteria = $n['id_kriteria'];
            $nilai_siswa = $n['nilai'];

            if ($nilai_siswa === null || $nilai_siswa === '') {
                continue;
            }

            $sifat = $n['sifat'];
            $max = $maxMinNilai[$id_kriteria]['max'] ?? 1;
            $min = $maxMinNilai[$id_kriteria]['min'] ?? 1;

            if ($sifat == 'benefit') {
                if ($max <= 0) {
                    $normalisasi[$id_siswa][$id_kriteria] = 0;
                } else {
                    $normalisasi[$id_siswa][$id_kriteria] = round($nilai_siswa / $max, 6);
                }
            } else { // cost
                // Jika ada nilai 0 di kriteria ini, gunakan 0.01 sebagai min
                $min = $cekNolPerKriteria[$id_kriteria] ? 0.01 : max($min, 0.01);
                $nilai_siswa = ($nilai_siswa == 0) ? 0.01 : $nilai_siswa;

                $normalisasi[$id_siswa][$id_kriteria] = round($min / $nilai_siswa, 6);
            }
        }

        return $normalisasi;
    }



    public function getBobotNormalisasi()
    {
        $kriteria = $this->getKriteria();

        // Pisahkan kriteria utama dan tambahan
        $utama = array_filter($kriteria, fn($k) => $k['tipe_kriteria'] == 'utama');
        $tambahan = array_filter($kriteria, fn($k) => $k['tipe_kriteria'] == 'tambahan');

        $totalBobotUtama = array_sum(array_column($utama, 'bobot'));
        $totalBobotTambahan = array_sum(array_column($tambahan, 'bobot'));

        foreach ($kriteria as &$k) {
            if ($k['tipe_kriteria'] == 'utama') {
                $k['bobot_normalisasi'] = $totalBobotUtama > 0 ? round($k['bobot'] / $totalBobotUtama, 4) : 0;
            } else {
                $k['bobot_normalisasi'] = $totalBobotTambahan > 0 ? round($k['bobot'] / $totalBobotTambahan, 4) : 0;
            }
        }
        return $kriteria;
    }
    public function getPerkalianNormalisasi($normalisasi)
    {
        $kriteria = $this->getBobotNormalisasi();

        // Siapkan array bobot per id_kriteria
        $bobotPerKriteria = [];
        foreach ($kriteria as $k) {
            $bobotPerKriteria[$k['id_kriteria']] = $k['bobot_normalisasi'];
        }

        $hasil = [];

        foreach ($normalisasi as $id_siswa => $nilai_kriteria) {
            foreach ($nilai_kriteria as $id_kriteria => $nilai_normalisasi) {
                $bobot = $bobotPerKriteria[$id_kriteria] ?? 0;
                $hasil[$id_siswa][$id_kriteria] = round($nilai_normalisasi * $bobot, 6);
            }
        }

        return $hasil;
    }

    public function hitungTotalNilai($normalisasi)
    {
        $kriteria = $this->getBobotNormalisasi();

        $bobotUtama = [];
        $bobotTambahan = [];

        foreach ($kriteria as $k) {
            if ($k['tipe_kriteria'] == 'utama') {
                $bobotUtama[$k['id_kriteria']] = $k['bobot_normalisasi'];
            } else {
                $bobotTambahan[$k['id_kriteria']] = $k['bobot_normalisasi'];
            }
        }

        $totalNilai = [];

        foreach ($normalisasi as $id_siswa => $nilai_kriteria) {
            $totalUtama = 0;
            $totalTambahan = 0;

            foreach ($nilai_kriteria as $id_kriteria => $nilai) {
                if (isset($bobotUtama[$id_kriteria])) {
                    $totalUtama += $nilai * $bobotUtama[$id_kriteria];
                } elseif (isset($bobotTambahan[$id_kriteria])) {
                    $totalTambahan += $nilai * $bobotTambahan[$id_kriteria];
                }
            }

            $total = round($totalUtama + $totalTambahan, 4);

            $totalNilai[$id_siswa] = [
                'total' => $total,
                'utama' => round($totalUtama, 4),
                'tambahan' => round($totalTambahan, 4)
            ];
        }

        return $totalNilai;
    }


    public function simpanHasil($hasil, $angkatan)
    {
        $this->db->table('hasil')->where('tahun_angkatan', $angkatan)->delete();

        $data = [];
        foreach ($hasil as $id_siswa => $nilai) {
            // Ambil kelas dari tabel siswa jika belum ada
            $kelas = $nilai['kelas'] ?? $this->getKelasByIdSiswa($id_siswa);

            $data[] = [
                'id_siswa' => $id_siswa,
                'total_nilai' => $nilai['total'],
                'nilai_utama' => $nilai['utama'],
                'nilai_tambahan' => $nilai['tambahan'],
                'tahun_angkatan' => $angkatan,
                'kelas' => $kelas
            ];
        }

        // Ranking berdasarkan total
        usort($data, fn($a, $b) => $b['total_nilai'] <=> $a['total_nilai']);

        foreach ($data as $index => $row) {
            $data[$index]['ranking'] = $index + 1;
        }

        if (!empty($data)) {
            $this->db->table('hasil')->insertBatch($data);
        }
    }
}
