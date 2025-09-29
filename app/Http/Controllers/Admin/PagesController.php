<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function finalisasi(): View
    {
        return view('admin.pages.finalisasi');
    }

    public function penerbitan(): View
    {
        return view('admin.pages.penerbitan');
    }

    public function pengaturan(): View
    {
        return view('admin.pages.pengaturan');
    }
}

