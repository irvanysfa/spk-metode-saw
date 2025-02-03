<?php

namespace App\Controllers;

use App\Models\HasilModel;
use CodeIgniter\Controller;

class HasilController extends Controller
{
    public function index()
    {
        $hasilModel = new HasilModel();
        $data['kelas_list'] = $hasilModel->getKelas();

        $kelasTerpilih = $this->request->getVar('kelas');
        if ($kelasTerpilih) {
            $data['hasil'] = $hasilModel->getHasilByKelas($kelasTerpilih);
            $data['kelasTerpilih'] = $kelasTerpilih;
        } else {
            $data['hasil'] = [];
            $data['kelasTerpilih'] = null;
        }

        return view('hasil/index', $data);
    }

    public function print_pdf()
    {
        helper('pdf');
    
        $hasilModel = new HasilModel();
        $kelasTerpilih = $this->request->getVar('kelas');
    
        if (!$kelasTerpilih) {
            return redirect()->to('hasil')->with('error', 'Pilih kelas terlebih dahulu.');
        }
    
        $data['hasil'] = $hasilModel->getHasilByKelas($kelasTerpilih);
        $data['kelasTerpilih'] = $kelasTerpilih;
    
        $html = view('hasil/pdf', $data);
    
        generate_pdf($html, 'hasil_perangkingan_' . $kelasTerpilih . '.pdf');
    }
    
}
