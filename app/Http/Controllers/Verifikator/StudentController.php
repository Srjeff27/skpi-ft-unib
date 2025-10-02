<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = User::query()
            ->where('role', 'mahasiswa')
            ->with('prodi');

        // Verifikator hanya melihat mahasiswa dalam prodi-nya
        if ($user->role === 'verifikator') {
            $query->where('prodi_id', $user->prodi_id);
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->integer('angkatan'));
        }

        $students = $query->orderBy('name')->paginate(20)->withQueryString();
        $angkatanList = User::where('role','mahasiswa')->whereNotNull('angkatan')->distinct()->orderBy('angkatan')->pluck('angkatan');

        return view('verifikator.students.index', compact('students','angkatanList'));
    }
}

