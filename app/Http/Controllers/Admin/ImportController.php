<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Services\ActivityLogger;

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
        $generatedPasswords = 0;
        while (($row = fgetcsv($fh)) !== false) {
            $role = strtolower($row[$map['role']] ?? 'mahasiswa');
            $role = in_array($role, ['admin','verifikator','mahasiswa'], true) ? $role : 'mahasiswa';

            $rawPassword = $row[$map['password']] ?? null;
            $passwordToSet = $rawPassword && strlen($rawPassword) >= 12 ? $rawPassword : Str::password(16);
            if (!$rawPassword || strlen($rawPassword) < 12) {
                $generatedPasswords++;
            }

            $data = [
                'name' => $row[$map['name']] ?? null,
                'email' => $row[$map['email']] ?? null,
                'role' => $role,
                'nim' => $row[$map['nim']] ?? null,
                'angkatan' => $row[$map['angkatan']] ?? null,
                'prodi_id' => null,
                'password' => Hash::make($passwordToSet),
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
        ActivityLogger::log($request->user(), 'admin.import.users', null, [
            'processed' => $count,
            'generated_passwords' => $generatedPasswords,
        ]);
        return back()->with('status', "Import selesai: {$count} user diproses. Password acak dibangkitkan untuk {$generatedPasswords} akun.");
    }
}
