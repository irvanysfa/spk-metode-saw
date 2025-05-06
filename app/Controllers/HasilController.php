<?php

namespace App\Controllers;

use App\Models\HasilModel;
use CodeIgniter\Controller;

class HasilController extends Controller
{
    public function index()
    {
        $hasilModel = new HasilModel();
        $data['tahun_list'] = $hasilModel->getTahunAngkatan();

        $tahunTerpilih = $this->request->getVar('tahun_angkatan');
        if ($tahunTerpilih) {
            $data['hasil'] = $hasilModel->getHasilByTahun($tahunTerpilih);
            $data['tahunTerpilih'] = $tahunTerpilih;
        } else {
            $data['hasil'] = [];
            $data['tahunTerpilih'] = null;
        }

        return view('hasil/index', $data);
    }

    public function print_pdf()
    {
        helper('pdf');

        $hasilModel = new HasilModel();
        $tahunAngkatanTerpilih = $this->request->getVar('tahun_angkatan');

        if (!$tahunAngkatanTerpilih) {
            return redirect()->to('hasil')->with('error', 'Pilih tahun angkatan terlebih dahulu.');
        }

        $data['hasil'] = $hasilModel->getHasilByTahunAngkatan($tahunAngkatanTerpilih);
        $data['tahunAngkatanTerpilih'] = $tahunAngkatanTerpilih;

        $html = view('hasil/pdf', $data);

        generate_pdf($html, 'hasil_perangkingan_' . $tahunAngkatanTerpilih . '.pdf');
    }


    public function deleteByTahun()
    {
        $hasilModel = new HasilModel();
        $tahunTerpilih = $this->request->getPost('tahun_angkatan');

        if ($tahunTerpilih) {
            $hasilModel->deleteHasilByTahun($tahunTerpilih);
            return redirect()->to('/hasil')->with('success', 'Data hasil perhitungan berhasil dihapus!');
        } else {
            return redirect()->to('/hasil')->with('error', 'Pilih tahun angkatan terlebih dahulu untuk menghapus data.');
        }
    }
}
