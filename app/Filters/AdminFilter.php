<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('loggedin')) {
            return redirect()->to(base_url('/login'));
        }

        // Cek apakah user adalah admin
        if (session()->get('level') !== 'admin') {
            // Jika bukan admin, redirect ke dashboard dengan pesan error
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke halaman tersebut!');
            return redirect()->to(base_url('/Dashboard/dashboard'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan setelah request
    }
}
