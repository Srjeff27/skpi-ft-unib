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
            'kategori_portfolio' => ['required','string','max:255'],
            'judul_kegiatan' => ['required','string','max:255'],
            'penyelenggara' => ['required','string','max:255'],
            'tanggal_dokumen' => ['required','date'],
            'nomor_dokumen' => ['nullable','string','max:255'],
            'nama_dokumen_id' => ['nullable','string','max:255'],
            'nama_dokumen_en' => ['nullable','string','max:255'],
            'deskripsi_kegiatan' => ['nullable','string'],
            'link_sertifikat' => ['required','url','max:255'],
        ];
    }
}



