<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'kategori' => ['required','string','max:255'],
            'tingkat' => ['nullable','in:regional,nasional,internasional'],
            'judul_kegiatan' => ['required','string','max:255'],
            'penyelenggara' => ['required','string','max:255'],
            'tanggal_mulai' => ['required','date'],
            'tanggal_selesai' => ['nullable','date','after_or_equal:tanggal_mulai'],
            'deskripsi_kegiatan' => ['nullable','string'],
            'bukti_link' => ['nullable','url','max:255'],
            'bukti_file' => ['nullable','file','mimetypes:application/pdf,image/jpeg,image/png,image/webp','max:2048'],
        ];
    }
}


