<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Setting;

class SystemSettingsController extends Controller
{
    public function index(): View
    {
        $data = [
            'univ_name' => Setting::get('univ_name', 'Universitas Bengkulu'),
            'faculty_name' => Setting::get('faculty_name', 'Fakultas Teknik'),
            'sk_pt' => Setting::get('sk_pt'),
            'grading' => Setting::get('grading'),
            'admission' => Setting::get('admission'),
            'languages' => Setting::get('languages', 'Indonesia & English'),
            'contact' => Setting::get('contact'),
            'narasi_pt_id' => Setting::get('narasi_pt_id'),
            'narasi_pt_en' => Setting::get('narasi_pt_en'),
            'narasi_kkni_id' => Setting::get('narasi_kkni_id'),
            'narasi_kkni_en' => Setting::get('narasi_kkni_en'),
            'logo_path' => Setting::get('logo_path'),
            'portfolio_open' => Setting::get('portfolio_open'),
            'portfolio_close' => Setting::get('portfolio_close'),
            'maintenance' => (bool) Setting::get('maintenance', 0),
        ];
        return view('admin.system_settings.index', compact('data'));
    }

    public function updateInstitution(Request $request)
    {
        $validated = $request->validate([
            'univ_name' => ['required','string','max:255'],
            'faculty_name' => ['required','string','max:255'],
            'sk_pt' => ['nullable','string'],
            'grading' => ['nullable','string'],
            'admission' => ['nullable','string'],
            'languages' => ['nullable','string','max:255'],
            'contact' => ['nullable','string'],
        ]);
        foreach ($validated as $k=>$v) Setting::set($k, $v);
        return back()->with('status','Pengaturan institusi tersimpan.');
    }

    public function updateNarratives(Request $request)
    {
        $validated = $request->validate([
            'narasi_pt_id' => ['nullable','string'],
            'narasi_pt_en' => ['nullable','string'],
            'narasi_kkni_id' => ['nullable','string'],
            'narasi_kkni_en' => ['nullable','string'],
        ]);
        foreach ($validated as $k=>$v) Setting::set($k, $v);
        return back()->with('status','Narasi SKPI tersimpan.');
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'portfolio_open' => ['nullable','date'],
            'portfolio_close' => ['nullable','date','after_or_equal:portfolio_open'],
            'maintenance' => ['nullable','boolean'],
            'logo' => ['nullable','image','max:5120'],
        ]);
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos','public');
            Setting::set('logo_path', $path);
        }
        Setting::set('portfolio_open', $validated['portfolio_open'] ?? null);
        Setting::set('portfolio_close', $validated['portfolio_close'] ?? null);
        Setting::set('maintenance', (int) ($validated['maintenance'] ?? 0));
        return back()->with('status','Pengaturan umum tersimpan.');
    }
}
