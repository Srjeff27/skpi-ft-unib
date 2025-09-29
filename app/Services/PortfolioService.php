<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;

class PortfolioService
{
    /**
     * Create portfolio for a given user with optional evidence file.
     */
    public function createForUser(User $user, array $validatedData, ?UploadedFile $evidenceFile = null): Portfolio
    {
        $data = $this->preparePersistableData($validatedData, $evidenceFile);
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        return Portfolio::create($data);
    }

    /**
     * Update portfolio with new data and optional evidence file.
     */
    public function updateForUser(Portfolio $portfolio, array $validatedData, ?UploadedFile $evidenceFile = null): bool
    {
        $data = $this->preparePersistableData($validatedData, $evidenceFile);
        return $portfolio->update($data);
    }

    /**
     * Normalize incoming validated data and handle file storage.
     */
    private function preparePersistableData(array $validatedData, ?UploadedFile $evidenceFile = null): array
    {
        $data = $validatedData;

        if ($evidenceFile !== null) {
            $path = $evidenceFile->store('certificates', 'public');
            // simpan ke kolom baru link_sertifikat
            $data['link_sertifikat'] = asset('storage/' . $path);
            unset($data['bukti_file']);
        }

        // jika user mengisi bukti_link manual (url), map ke kolom baru
        if (isset($data['bukti_link'])) {
            $data['link_sertifikat'] = $data['bukti_link'];
            unset($data['bukti_link']);
        }

        // Backward-compat: map to legacy columns if needed
        // mapping ke kolom baru kategori_portfolio jika tersedia
        if (Schema::hasColumn('portfolios', 'kategori_portfolio') && isset($data['kategori'])) {
            $data['kategori_portfolio'] = $data['kategori'];
            unset($data['kategori']);
        }

        // Jika ada input tanggal_mulai, gunakan sebagai tanggal_dokumen
        if (isset($data['tanggal_mulai'])) {
            $data['tanggal_dokumen'] = $data['tanggal_mulai'];
            unset($data['tanggal_mulai']);
        }
        
        // Hapus kolom yang sudah tidak ada di tabel
        unset($data['tanggal_selesai']);
        unset($data['tingkat']);

        // Only keep keys that exist as columns to avoid SQL errors
        $columns = Schema::getColumnListing('portfolios');
        $data = array_intersect_key($data, array_flip($columns));

        return $data;
    }
}


