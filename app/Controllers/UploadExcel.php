<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\KriteriaModel;
use App\Models\NilaiModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UploadExcel extends BaseController
{
    public function index()
    {
        return view('siswa/upload_excel');
    }

    public function import()
    {
        $file = $this->request->getFile('fileexcel');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $spreadsheet = IOFactory::load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // biar aman

            $siswaModel = new SiswaModel();
            $kriteriaModel = new KriteriaModel();
            $nilaiModel = new NilaiModel();

            $allKriteria = $kriteriaModel->findAll();
            $mapKriteria = [];
            foreach ($allKriteria as $kriteria) {
                $mapKriteria[$kriteria['kode_kriteria']] = $kriteria['id_kriteria'];
            }

            $header = array_values($sheet)[0]; // ambil baris pertama
            $kriteriaColumnMap = [];

            foreach ($header as $index => $kolom) {
                if ($index >= 'E' && isset($mapKriteria[$kolom])) {
                    $kriteriaColumnMap[$index] = $mapKriteria[$kolom];
                }
            }

            foreach ($sheet as $i => $row) {
                if ($i == 1) continue; // skip header (row 1 di excel)

                $nama = $row['A'] ?? '';
                $kodeAlternatif = $row['B'] ?? '';
                $kelas = $row['C'] ?? '';
                $angkatan = $row['D'] ?? '';

                if (empty($nama) || empty($kodeAlternatif)) {
                    continue;
                }

                $existing = $siswaModel->where('kode_alternatif', $kodeAlternatif)->first();

                if ($existing) {
                    $siswaModel->update($existing['id_siswa'], [
                        'nama_siswa' => $nama,
                        'kelas' => $kelas,
                        'tahun_angkatan' => $angkatan
                    ]);
                    $idSiswa = $existing['id_siswa'];
                    $nilaiModel->where('id_siswa', $idSiswa)->delete();
                } else {
                    $siswaModel->insert([
                        'nama_siswa' => $nama,
                        'kode_alternatif' => $kodeAlternatif,
                        'kelas' => $kelas,
                        'tahun_angkatan' => $angkatan
                    ]);
                    $idSiswa = $siswaModel->getInsertID();
                }

                foreach ($kriteriaColumnMap as $colIndex => $idKriteria) {
                    $nilai = $row[$colIndex] ?? null;

                    if (!is_numeric($nilai)) {
                        continue;
                    }

                    $nilaiModel->insert([
                        'id_siswa' => $idSiswa,
                        'id_kriteria' => $idKriteria,
                        'nilai' => $nilai
                    ]);
                }
            }

            return redirect()->to('/siswa')->with('success', 'Data berhasil diimport!');
        }

        return redirect()->to('/upload-excel')->with('message', 'File tidak valid!');
    }
}
