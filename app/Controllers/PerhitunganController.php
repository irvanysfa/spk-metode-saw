<?php

namespace App\Controllers;

use App\Models\PerhitunganModel;
use CodeIgniter\Controller;

class PerhitunganController extends Controller
{
    public function index()
    {
        $perhitunganModel = new PerhitunganModel();
        $data['tahun_angkatan'] = $perhitunganModel->getTahunAngkatan(); // ganti getKelas

        $angkatanTerpilih = $this->request->getVar('tahun_angkatan');
        if ($angkatanTerpilih) {
            $data['siswa'] = $perhitunganModel->getSiswaByAngkatan($angkatanTerpilih);
            $data['kriteria'] = $perhitunganModel->getBobotNormalisasi();
            $nilai_db = $perhitunganModel->getNilaiWithSiswaKriteriaByAngkatan($angkatanTerpilih);

            $nilai = [];
            foreach ($nilai_db as $n) {
                $nilai[$n['id_siswa']][$n['id_kriteria']] = $n['nilai'];
            }
            $data['nilai'] = $nilai;

            $data['max_min_nilai'] = $perhitunganModel->getMaxMinNilaiByAngkatan($angkatanTerpilih);
            $data['normalisasi'] = $perhitunganModel->hitungNormalisasi($nilai_db, $angkatanTerpilih);
            $data['perkalian'] = $perhitunganModel->getPerkalianNormalisasi($data['normalisasi']);
            $data['hasil'] = $perhitunganModel->hitungTotalNilai($data['normalisasi']);
            $perhitunganModel->simpanHasil($data['hasil'], $angkatanTerpilih); // bisa disimpan per angkatan
            $data['hasil'] = [];
            foreach ($perhitunganModel->getHasilByAngkatan($angkatanTerpilih) as $h) {
                $data['hasil'][$h['id_siswa']] = [
                    'total' => $h['total_nilai'],
                    'utama' => $h['nilai_utama'],
                    'tambahan' => $h['nilai_tambahan'],
                    'ranking' => $h['ranking']
                ];
            }
        }

        return view('perhitungan/index', $data);
    }
}
