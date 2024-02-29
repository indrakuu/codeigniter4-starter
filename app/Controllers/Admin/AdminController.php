<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function index()
    {
        $breadcrumb = [
            'title' => 'Dashboard',
            'page' => [
                ['title' => 'Dashboard', 'url_to' => 'dashboard', 'active' => true],
            ],
        ];

        return view('admin/dashboard', compact('breadcrumb'));
    }
}
