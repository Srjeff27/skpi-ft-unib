<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\UploadedFile;

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
            $data['bukti_link'] = asset('storage/' . $path);
            unset($data['bukti_file']);
        }

        return $data;
    }
}


