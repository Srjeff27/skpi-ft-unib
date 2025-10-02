<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Official;
use App\Models\Setting;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use ZipArchive;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class CetakSkpiController extends Controller
{
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
        $prodis = \App\Models\Prodi::orderBy('nama_prodi')->get(['id','nama_prodi']);

        return view('admin.cetak_skpi.index', compact('students','prodis','periods','periode'));
    }

    public function preview(User $user)
    {
        $verifiedPortfolios = $user->portfolios()->where('status','verified')->orderByDesc('verified_at')->get();
        $qrUrl = URL::temporarySignedRoute('skpi.verify', now()->addYears(5), ['user' => $user->id]);
        $qrBase64 = $this->makeQrBase64($qrUrl);

        $html = view('student.skpi.pdf', compact('user','verifiedPortfolios','qrBase64'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', base_path('public'));
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $filename = 'SKPI-Preview-'.Str::slug($user->name).'.pdf';
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
    }

    public function printSingle(User $user)
    {
        $verifiedPortfolios = $user->portfolios()->where('status','verified')->orderByDesc('verified_at')->get();
        $qrUrl = URL::temporarySignedRoute('skpi.verify', now()->addYears(5), ['user' => $user->id]);
        $qrBase64 = $this->makeQrBase64($qrUrl);
        $html = view('student.skpi.pdf', compact('user','verifiedPortfolios','qrBase64'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', base_path('public'));
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $filename = 'SKPI-'.Str::slug($user->name).'.pdf';
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function printBulk(Request $request)
    {
        $ids = collect($request->input('selected', []))->filter()->map('intval')->all();
        if (empty($ids)) {
            return back()->with('status','Pilih minimal satu mahasiswa.');
        }
        $users = User::with('prodi')->whereIn('id', $ids)->get();
        $zip = new ZipArchive();
        $zipName = 'SKPI-Bulk-'.now()->format('Ymd-His').'.zip';
        $zipPath = storage_path('app/'.$zipName);
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->withErrors(['zip'=>'Gagal membuat arsip ZIP']);
        }
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', base_path('public'));

        foreach ($users as $user) {
            $verifiedPortfolios = $user->portfolios()->where('status','verified')->orderByDesc('verified_at')->get();
            $qrUrl = URL::temporarySignedRoute('skpi.verify', now()->addYears(5), ['user' => $user->id]);
            $qrBase64 = $this->makeQrBase64($qrUrl);
            $html = view('student.skpi.pdf', compact('user','verifiedPortfolios','qrBase64'))->render();
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = $dompdf->output();
            $zip->addFromString('SKPI-'.Str::slug($user->name).'.pdf', $pdf);
        }
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    private function makeQrBase64(string $text): string
    {
        $opts = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 4,
            'imageBase64' => true,
        ]);
        $qrcode = new QRCode($opts);
        return $qrcode->render($text);
    }
}
