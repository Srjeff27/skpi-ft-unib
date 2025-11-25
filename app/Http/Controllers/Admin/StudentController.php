<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Services\ActivityLogger;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->where('role','mahasiswa')->with('prodi');
        if ($request->filled('prodi_id')) $query->where('prodi_id', $request->integer('prodi_id'));
        if ($request->filled('angkatan')) $query->where('angkatan', $request->integer('angkatan'));
        $students = $query->orderBy('name')->paginate(20)->withQueryString();
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        $angkatanList = User::where('role','mahasiswa')->whereNotNull('angkatan')->distinct()->orderBy('angkatan')->pluck('angkatan');
        return view('admin.students.index', compact('students','prodis','angkatanList'));
    }

    public function create(): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.students.form', ['student' => new User(['role'=>'mahasiswa']), 'prodis'=>$prodis]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'password' => ['required','min:8'],
            'nim' => ['nullable','string','max:50'],
            'tempat_lahir' => ['nullable','string','max:255'],
            'tanggal_lahir' => ['nullable','date'],
            'nomor_hp' => ['nullable','string','max:20'],
            'angkatan' => ['nullable','integer'],
            'prodi_id' => ['nullable','exists:prodis,id'],
            'tanggal_lulus' => ['nullable','date'],
            'nomor_ijazah' => ['nullable','string','max:255'],
            'nomor_skpi' => ['nullable','string','max:255'],
            'gelar_id' => ['nullable','string','max:255'],
            'gelar_en' => ['nullable','string','max:255'],
            'avatar' => ['nullable','in:mahasiswa_male,mahasiswa_female,dosen,verifikator,admin'],
        ]);
        $data['role'] = 'mahasiswa';
        $data['password'] = Hash::make($data['password']);
        $data['profile_photo_path'] = null;
        User::create($data);
        return redirect()->route('admin.students.index')->with('status','Mahasiswa dibuat');
    }

    public function edit(User $student): View
    {
        abort_unless($student->role==='mahasiswa', 404);
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);
        return view('admin.students.form', compact('student','prodis'));
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        abort_unless($student->role==='mahasiswa', 404);
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$student->id],
            'password' => ['nullable','min:8'],
            'nim' => ['nullable','string','max:50'],
            'tempat_lahir' => ['nullable','string','max:255'],
            'tanggal_lahir' => ['nullable','date'],
            'nomor_hp' => ['nullable','string','max:20'],
            'angkatan' => ['nullable','integer'],
            'prodi_id' => ['nullable','exists:prodis,id'],
            'tanggal_lulus' => ['nullable','date'],
            'nomor_ijazah' => ['nullable','string','max:255'],
            'nomor_skpi' => ['nullable','string','max:255'],
            'gelar_id' => ['nullable','string','max:255'],
            'gelar_en' => ['nullable','string','max:255'],
            'avatar' => ['nullable','in:mahasiswa_male,mahasiswa_female,dosen,verifikator,admin'],
        ]);
        if (!empty($data['password'])) $data['password'] = Hash::make($data['password']); else unset($data['password']);
        $data['role'] = 'mahasiswa';
        $data['profile_photo_path'] = null;
        $student->update($data);
        return redirect()->route('admin.students.index')->with('status','Mahasiswa diperbarui');
    }

    public function destroy(Request $request, User $student): RedirectResponse
    {
        abort_unless($student->role==='mahasiswa', 404);
        $student->delete();
        ActivityLogger::log($request->user(), 'admin.students.destroy', $student);
        return back()->with('status','Mahasiswa dihapus');
    }
}
