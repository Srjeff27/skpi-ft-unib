<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Prodi;
use App\Models\Curriculum;
use App\Models\CplItem;
use Illuminate\Support\Facades\Schema;

class CplController extends Controller
{
    public function index(Request $request): View
    {
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi','jenjang']);
        $selectedProdiId = $request->integer('prodi_id');
        $selectedProdi = $prodis->firstWhere('id', $selectedProdiId);

        $curricula = collect();
        if ($selectedProdiId && Schema::hasTable('curricula')) {
            $curricula = Curriculum::where('prodi_id', $selectedProdiId)
                ->orderByDesc('year')
                ->orderBy('name')
                ->get();
        }

        return view('admin.academic.cpl.index', compact('prodis','selectedProdiId','selectedProdi','curricula'));
    }

    public function manage(Curriculum $curriculum): View
    {
        $curriculum->load('prodi');
        $items = $curriculum->cplItems()->orderBy('order')->latest('id')->get();
        $grouped = [
            'sikap' => collect(),
            'pengetahuan' => collect(),
            'umum' => collect(),
            'khusus' => collect(),
        ];
        foreach ($items as $it) {
            $grouped[$it->category] = ($grouped[$it->category] ?? collect())->push($it);
        }

        return view('admin.academic.cpl.manage', [
            'curriculum' => $curriculum,
            'itemsByCategory' => $grouped,
        ]);
    }

    // Kurikulum
    public function storeCurriculum(Request $request)
    {
        if (! Schema::hasTable('curricula')) {
            return back()->withErrors(['curriculum' => 'Tabel curricula belum ada. Jalankan migrasi: php artisan migrate'])->withInput();
        }
        $data = $request->validate([
            'prodi_id' => ['required','exists:prodis,id'],
            'name' => ['required','string','max:255'],
            'year' => ['nullable','integer','between:1900,2100'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? false);
        $curriculum = Curriculum::create($data);
        if ($curriculum->is_active) {
            Curriculum::where('prodi_id',$curriculum->prodi_id)
                ->where('id','!=',$curriculum->id)
                ->update(['is_active'=>false]);
        }
        return redirect()->route('admin.cpl.index', ['prodi_id'=>$curriculum->prodi_id])
            ->with('status','Kurikulum ditambahkan.');
    }

    public function destroyCurriculum(Curriculum $curriculum)
    {
        if (! Schema::hasTable('curricula')) {
            return back()->withErrors(['curriculum' => 'Tabel curricula belum ada. Jalankan migrasi: php artisan migrate']);
        }
        $prodiId = $curriculum->prodi_id;
        $curriculum->delete();
        return redirect()->route('admin.cpl.index', ['prodi_id'=>$prodiId])->with('status','Kurikulum dihapus.');
    }

    // CPL Items
    public function storeItem(Request $request, Curriculum $curriculum)
    {
        if (! Schema::hasTable('cpl_items')) {
            return back()->withErrors(['cpl' => 'Tabel cpl_items belum ada. Jalankan migrasi: php artisan migrate']);
        }
        $data = $request->validate([
            'category' => ['required','in:sikap,pengetahuan,umum,khusus'],
            'code' => ['nullable','string','max:50'],
            'desc_id' => ['required','string'],
            'desc_en' => ['nullable','string'],
            'order' => ['nullable','integer','min:0','max:65535'],
        ]);
        $data['curriculum_id'] = $curriculum->id;
        CplItem::create($data);
        return back()->with('status','CPL ditambahkan.');
    }

    public function destroyItem(CplItem $item)
    {
        $curriculumId = $item->curriculum_id;
        $item->delete();
        return redirect()->route('admin.cpl.manage', $curriculumId)->with('status','CPL dihapus.');
    }

    // Edit Curriculum
    public function editCurriculum(Curriculum $curriculum): View
    {
        $curriculum->load('prodi');
        return view('admin.academic.cpl.edit_curriculum', compact('curriculum'));
    }

    public function updateCurriculum(Request $request, Curriculum $curriculum)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'year' => ['nullable','integer','between:1900,2100'],
            'is_active' => ['nullable','boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? false);
        $curriculum->update($data);
        if ($curriculum->is_active) {
            Curriculum::where('prodi_id',$curriculum->prodi_id)
                ->where('id','!=',$curriculum->id)
                ->update(['is_active'=>false]);
        }
        return redirect()->route('admin.cpl.index', ['prodi_id'=>$curriculum->prodi_id])->with('status','Kurikulum diperbarui.');
    }

    // Edit CPL Item
    public function editItem(CplItem $item): View
    {
        $curriculum = $item->curriculum()->with('prodi')->first();
        return view('admin.academic.cpl.edit_item', compact('item','curriculum'));
    }

    public function updateItem(Request $request, CplItem $item)
    {
        $data = $request->validate([
            'category' => ['required','in:sikap,pengetahuan,umum,khusus'],
            'code' => ['nullable','string','max:50'],
            'desc_id' => ['required','string'],
            'desc_en' => ['nullable','string'],
            'order' => ['nullable','integer','min:0','max:65535'],
        ]);
        $item->update($data);
        return redirect()->route('admin.cpl.manage', $item->curriculum_id)->with('status','CPL diperbarui.');
    }
}
