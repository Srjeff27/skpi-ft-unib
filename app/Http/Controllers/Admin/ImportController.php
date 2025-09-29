<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ImportController extends Controller
{
    public function index(): View
    {
        return view('admin.import.index');
    }

    public function importUsers(Request $request): RedirectResponse
    {
        $request->validate(['file' => ['required','file','mimes:csv,txt']]);
        $file = $request->file('file')->getRealPath();
        $fh = fopen($file, 'r');
        $header = fgetcsv($fh);
        $map = array_flip($header);
        $count = 0;
        while (($row = fgetcsv($fh)) !== false) {
            $data = [
                'name' => $row[$map['name']] ?? null,
                'email' => $row[$map['email']] ?? null,
                'role' => $row[$map['role']] ?? 'mahasiswa',
                'nim' => $row[$map['nim']] ?? null,
                'angkatan' => $row[$map['angkatan']] ?? null,
                'prodi_id' => null,
                'password' => Hash::make($row[$map['password']] ?? 'password123'),
            ];
            if (isset($map['prodi']) && !empty($row[$map['prodi']])) {
                $prodi = Prodi::firstOrCreate(['nama_prodi' => $row[$map['prodi']]], ['jenjang' => 'S1']);
                $data['prodi_id'] = $prodi->id;
            }
            if (!empty($data['email'])) {
                User::updateOrCreate(['email' => $data['email']], $data);
                $count++;
            }
        }
        fclose($fh);
        return back()->with('status', "Import selesai: {$count} user diproses");
    }
}

