<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $model = new AdminModel();
        $data = [
            'nama_admin' => $this->request->getPost('nama_admin'),
            'user_name' => $this->request->getPost('user_name'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];
        $model->insert($data);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $model = new AdminModel();

        $username = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        // Validasi input tidak boleh kosong
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi!');
        }

        // Cek apakah username ada di database
        $admin = $model->where('user_name', $username)->first();

        if ($admin && password_verify($password, $admin['password'])) {
            // Jika password valid, set session
            $sessionData = [
                'id_admin'   => $admin['id_admin'],
                'nama_admin' => $admin['nama_admin'],
                'isLoggedIn' => true,
                'last_login' => date('Y-m-d H:i:s')
            ];
            session()->set($sessionData);

            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }


    public function logout()
    {
        session()->destroy(); // Hapus semua session
        return redirect()->to('/login')->with('success', 'Anda telah logout.');
    }


    public function dashboard()
    {
        // Menampilkan halaman dashboard setelah login
        return view('dashboard');
    }
}
