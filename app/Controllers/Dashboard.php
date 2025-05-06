<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        if (!session()->has('nama_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu!');
        }
    
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT tahun_angkatan, AVG(total_nilai) AS rata_rata
            FROM hasil
            WHERE ranking <= 10
            GROUP BY tahun_angkatan
            ORDER BY tahun_angkatan
        ");
    
        $data['grafik'] = $query->getResultArray();
    
        return view('dashboard', $data);
    }
    
}
