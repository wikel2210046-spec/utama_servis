<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Laporan extends BaseController
{
    public function index()
    {
        // Cek session login
        if (!session()->get('loggedin')) {
            return redirect()->to(base_url('/login'));
        }

        $data = [
            'title' => 'Pusat Laporan',
            'username' => session()->get('nama')
        ];

        return view('Laporan/index', $data);
    }
}
