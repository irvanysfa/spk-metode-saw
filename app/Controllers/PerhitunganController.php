<?php

namespace App\Controllers;

use App\Models\PerhitunganModel;
use CodeIgniter\Controller;

class PerhitunganController extends Controller
{
    public function index()
    {
        $perhitunganModel = new PerhitunganModel();
        $data['kelas'] = $perhitunganModel->getKelas();

        $kelasTerpilih = $this->request->getVar('kelas');
        if ($kelasTerpilih) {
            $data['siswa'] = $perhitunganModel->getSiswaByKelas($kelasTerpilih);
            $data['kriteria'] = $perhitunganModel->getBobotNormalisasi();
            $nilai_db = $perhitunganModel->getNilaiWithSiswaKriteria($kelasTerpilih);

            // **Perbaikan Format Nilai**
            $nilai = [];
            foreach ($nilai_db as $n) {
                $nilai[$n['id_siswa']][$n['id_kriteria']] = $n['nilai'];
            }
            $data['nilai'] = $nilai;

            $data['max_min_nilai'] = $perhitunganModel->getMaxMinNilai($kelasTerpilih);
            $data['normalisasi'] = $perhitunganModel->hitungNormalisasi($nilai_db, $kelasTerpilih);
            $data['hasil'] = $perhitunganModel->hitungTotalNilai($data['normalisasi']);

            $perhitunganModel->simpanHasil($data['hasil'], $kelasTerpilih);
        }

        return view('perhitungan/index', $data);
    }
}
