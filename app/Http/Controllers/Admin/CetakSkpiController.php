<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Prodi;
use App\Services\SkpiService;

class CetakSkpiController extends Controller
{
    protected $skpiService;

    public function __construct(SkpiService $skpiService)
    {
        $this->skpiService = $skpiService;
    }

    public function index(Request $request): View
    {
        $periods = User::where('role','mahasiswa')
            ->whereNotNull('tanggal_lulus')
            ->selectRaw("DATE_FORMAT(tanggal_lulus, '%Y-%m') as ym")
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('ym');

        $query = User::with('prodi')
            ->where('role','mahasiswa')
            ->whereNotNull('tanggal_lulus');

        $periode = $request->string('periode')->toString();
        if ($periode) {
            $start = $periode.'-01';
            $end = date('Y-m-d', strtotime($start.' +1 month'));
            $query->whereBetween('tanggal_lulus', [$start, $end]);
        }
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->integer('prodi_id'));
        }
        if ($request->filled('q')) {
            $q = '%'.$request->string('q')->toString().'%';
            $query->where(function($x) use ($q){
                $x->where('name','like',$q)->orWhere('nim','like',$q);
            });
        }

        $students = $query->orderBy('name')->paginate(20)->withQueryString();
        $prodis = Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);

        return view('admin.cetak_skpi.index', compact('students','prodis','periods','periode'));
    }

    public function preview(User $user)
    {
        return $this->skpiService->generatePdf($user, false);
    }

    public function printSingle(User $user)
    {
        return $this->skpiService->generatePdf($user, true);
    }

    public function printBulk(Request $request)
    {
        $ids = collect($request->input('selected', []))->filter()->map('intval')->all();
        if (empty($ids)) {
            return back()->with('status','Pilih minimal satu mahasiswa.');
        }
        
        $result = $this->skpiService->generateBulkPdf($ids);
        
        if (!$result) {
            return back()->withErrors(['zip'=>'Gagal membuat arsip ZIP']);
        }
        
        return $result;
    }
}
