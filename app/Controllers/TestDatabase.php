<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TestDatabase extends BaseController
{
    public function index()
    {
        // Coba koneksi ke database
        $db = \Config\Database::connect();

        if ($db->connect()) {
            return "Koneksi ke database berhasil!";
        } else {
            return "Koneksi ke database gagal.";
        }
    }
}
