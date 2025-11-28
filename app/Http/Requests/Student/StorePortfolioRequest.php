<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
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
            'link_sertifikat' => ['nullable','url','max:255','required_without:bukti_file'],
            'bukti_file' => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5120','required_without:link_sertifikat'],
        ];
    }
}

