<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioEvidenceController extends Controller
{
    public function show(Request $request, Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $link = $portfolio->link_sertifikat;

        if (Str::startsWith($link, ['http://', 'https://'])) {
            return redirect()->away($link);
        }

        if ($link && Storage::disk('local')->exists($link)) {
            // Simpan di disk private (local) dan unduh melalui controller terautentikasi.
            return Storage::disk('local')->download($link);
        }

        abort(404);
    }
}
