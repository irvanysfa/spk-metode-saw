<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->has('nama_admin')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu!');
        }

        return view('dashboard'); // Menampilkan halaman dashboard
    }
}
