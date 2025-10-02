<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PejabatController extends Controller
{
    public function index(): View
    {
        return view('admin.pejabat.index');
    }
}

