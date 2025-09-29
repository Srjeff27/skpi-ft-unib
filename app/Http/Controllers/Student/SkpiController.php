<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\URL;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class SkpiController extends Controller
{
    public function download(Request $request)
    {
        $user = $request->user();

        // Hanya izinkan jika sudah memiliki nomor SKPI atau minimal 1 portofolio terverifikasi
        $verifiedPortfolios = $user->portfolios()->where('status', 'verified')->orderByDesc('verified_at')->get();
        if (! $user->nomor_skpi && $verifiedPortfolios->isEmpty()) {
            return redirect()->route('dashboard')->with('status', 'Belum ada data untuk diterbitkan.');
        }

        $qrUrl = URL::temporarySignedRoute('skpi.verify', now()->addYears(5), ['user' => $user->id]);
        $qrBase64 = $this->makeQrBase64($qrUrl);

        $html = view('student.skpi.pdf', [
            'user' => $user,
            'verifiedPortfolios' => $verifiedPortfolios,
            'qrBase64' => $qrBase64,
        ])->render();

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
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
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

    public function apply(Request $request)
    {
        $user = $request->user();
        ActivityLogger::log($user, 'student.skpi.apply', $user);
        return back()->with('status','Pengajuan SKPI telah dikirim. Admin akan meninjau.');
    }
}
