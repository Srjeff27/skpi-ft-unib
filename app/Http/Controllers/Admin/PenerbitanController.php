<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finalization;
use App\Models\Setting;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class PenerbitanController extends Controller
{
    public function index(Request $request): View
    {
        $lockedPeriods = Finalization::where('is_locked', true)->orderByDesc('period_ym')->pluck('period_ym');
        $periode = $request->string('periode')->toString();
        if (!$periode && $lockedPeriods->isNotEmpty()) {
            $periode = $lockedPeriods->first();
        }

        $students = collect();
        if ($periode) {
            $start = $periode.'-01';
            $end = date('Y-m-d', strtotime($start.' +1 month'));
            $students = User::with('prodi')
                ->where('role','mahasiswa')
                ->whereBetween('tanggal_lulus', [$start,$end])
                ->orderBy('name')
                ->paginate(20)
                ->withQueryString();
        }

        return view('admin.penerbitan.index', compact('lockedPeriods','periode','students'));
    }

    public function publishSingle(Request $request, User $user)
    {
        $period = $this->periodFromUser($user);
        if (!$period) return back()->withErrors(['user'=>'Mahasiswa belum memiliki tanggal lulus.']);
        if (! Finalization::where('period_ym',$period)->where('is_locked',true)->exists()) {
            return back()->withErrors(['periode'=>'Periode belum terkunci (final).']);
        }
        if (!$user->nomor_skpi) {
            $user->nomor_skpi = $this->generateSkpiNumber($period);
            $user->save();
        }
        return back()->with('status','SKPI resmi diterbitkan untuk '.$user->name);
    }

    public function publishBulk(Request $request)
    {
        $periode = $request->validate(['periode'=>['required','date_format:Y-m']])['periode'];
        if (! Finalization::where('period_ym',$periode)->where('is_locked',true)->exists()) {
            return back()->withErrors(['periode'=>'Periode belum terkunci (final).']);
        }
        $ids = collect($request->input('selected', []))->filter()->map('intval');
        if ($ids->isEmpty()) return back()->with('status','Pilih minimal satu mahasiswa.');
        $users = User::whereIn('id',$ids)->get();
        foreach ($users as $u) {
            if (!$u->nomor_skpi) {
                $u->nomor_skpi = $this->generateSkpiNumber($periode);
                $u->save();
            }
        }
        return back()->with('status','Penerbitan massal selesai.');
    }

    public function download(User $user)
    {
        if (!$user->nomor_skpi) return back()->withErrors(['user'=>'Belum diterbitkan.']);
        $verifiedPortfolios = $user->portfolios()->where('status','verified')->where('is_locked',true)->orderByDesc('verified_at')->get();
        $qrUrl = URL::temporarySignedRoute('skpi.verify', now()->addYears(10), ['user' => $user->id]);
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

    public function verify(User $user)
    {
        $signed = URL::temporarySignedRoute('skpi.verify', now()->addYears(10), ['user' => $user->id]);
        return redirect($signed);
    }

    private function periodFromUser(User $user): ?string
    {
        if (! $user->tanggal_lulus) return null;
        return date('Y-m', strtotime($user->tanggal_lulus));
    }

    private function generateSkpiNumber(string $period): string
    {
        // counter per periode disimpan pada settings: skpi_counter_YYYY-MM
        $key = 'skpi_counter_'.$period;
        $current = (int) Setting::get($key, 0);
        $next = $current + 1;
        Setting::set($key, (string) $next);
        // Format: {counter}/SKPI/FT-UNIB/{ROMAN}/{YEAR}
        [$year,$month] = explode('-', $period);
        $roman = $this->toRoman((int)$month);
        return sprintf('%03d/SKPI/FT-UNIB/%s/%s', $next, $roman, $year);
    }

    private function toRoman(int $month): string
    {
        $map = [1=>'I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        return $map[$month] ?? '';
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

