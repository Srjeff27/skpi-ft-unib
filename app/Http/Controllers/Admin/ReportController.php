<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Prodi;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    public function index(): View
    {
        $byStatus = [
            'verified' => Portfolio::where('status','verified')->count(),
            'rejected' => Portfolio::where('status','rejected')->count(),
            'pending' => Portfolio::where('status','pending')->count(),
        ];
        $byProdi = Prodi::withCount('users')->get();
        return view('admin.reports.index', compact('byStatus','byProdi'));
    }

    public function exportCsv(): Response
    {
        $rows = [];
        $rows[] = ['Status','Jumlah'];
        foreach (['verified','rejected','pending'] as $s) {
            $rows[] = [$s, Portfolio::where('status',$s)->count()];
        }
        $csv = '';
        foreach ($rows as $r) { $csv .= implode(',', array_map(fn($v)=>'"'.str_replace('"','""',$v).'"', $r))."\n"; }

        return new Response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-status.csv"',
        ]);
    }

    public function exportPdf(): Response
    {
        $byStatus = [
            'verified' => Portfolio::where('status','verified')->count(),
            'rejected' => Portfolio::where('status','rejected')->count(),
            'pending' => Portfolio::where('status','pending')->count(),
        ];
        $html = view('admin.reports.pdf', compact('byStatus'))->render();
        $opts = new Options();
        $opts->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($opts);
        $dompdf->loadHtml($html,'UTF-8');
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="laporan.pdf"',
        ]);
    }
}

