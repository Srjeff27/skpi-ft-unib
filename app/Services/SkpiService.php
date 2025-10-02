<?php

namespace App\Services;

use App\Models\User;
use App\Models\Official;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use ZipArchive;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class SkpiService
{
    /**
     * Generate QR code as base64 string
     *
     * @param string $text
     * @return string
     */
    public function generateQrCode(string $text): string
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

    /**
     * Generate verification URL for SKPI
     *
     * @param User $user
     * @return string
     */
    public function generateVerificationUrl(User $user): string
    {
        return URL::temporarySignedRoute('skpi.verify', now()->addYears(5), ['user' => $user->id]);
    }

    /**
     * Generate PDF for SKPI
     *
     * @param User $user
     * @param bool $download
     * @return \Illuminate\Http\Response
     */
    public function generatePdf(User $user, bool $download = false)
    {
        $verifiedPortfolios = $user->portfolios()->where('status', 'verified')->orderByDesc('verified_at')->get();
        $qrUrl = $this->generateVerificationUrl($user);
        $qrBase64 = $this->generateQrCode($qrUrl);
        
        // Get official data if available
        $official = Official::where('is_active', true)->first();

        $html = view('student.skpi.pdf', compact('user', 'verifiedPortfolios', 'qrBase64', 'official'))->render();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', base_path('public'));
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'SKPI-' . Str::slug($user->name) . '.pdf';
        $disposition = $download ? 'attachment' : 'inline';
        
        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
        ]);
    }

    /**
     * Generate bulk PDFs as ZIP archive
     *
     * @param array $userIds
     * @return \Illuminate\Http\Response|null
     */
    public function generateBulkPdf(array $userIds)
    {
        if (empty($userIds)) {
            return null;
        }

        $users = User::with('prodi')->whereIn('id', $userIds)->get();
        $zip = new ZipArchive();
        $zipName = 'SKPI-Bulk-' . now()->format('Ymd-His') . '.zip';
        $zipPath = storage_path('app/' . $zipName);
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return null;
        }
        
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('chroot', base_path('public'));
        
        // Get official data if available
        $official = Official::where('is_active', true)->first();

        foreach ($users as $user) {
            $verifiedPortfolios = $user->portfolios()->where('status', 'verified')->orderByDesc('verified_at')->get();
            $qrUrl = $this->generateVerificationUrl($user);
            $qrBase64 = $this->generateQrCode($qrUrl);
            
            $html = view('student.skpi.pdf', compact('user', 'verifiedPortfolios', 'qrBase64', 'official'))->render();
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $pdf = $dompdf->output();
            $zip->addFromString('SKPI-' . Str::slug($user->name) . '.pdf', $pdf);
        }
        
        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}