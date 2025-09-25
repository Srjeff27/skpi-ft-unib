<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Already handled by middleware
    }

    public function rules(): array
    {
        return [
            'kategori_portfolio' => ['required', 'string', 'in:Penghargaan dan Pemenang Kejuaraan,Pengalaman Organisasi,Spesifikasi Tugas Akhir,Bahasa Internasional,Magang Industri,Pendidikan Karakter'],
            'judul_kegiatan' => ['required', 'string', 'max:255'],
            'penyelenggara' => ['required', 'string', 'max:255'],
            'nomor_dokumen' => ['nullable', 'string', 'max:255'],
            'tanggal_dokumen' => ['nullable', 'date'],
            'nama_dokumen_id' => ['nullable', 'string', 'max:255'],
            'nama_dokumen_en' => ['nullable', 'string', 'max:255'],
            'deskripsi_kegiatan' => ['required', 'string'],
            'link_sertifikat' => ['required', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_portfolio.required' => 'Kategori portofolio harus dipilih.',
            'kategori_portfolio.in' => 'Kategori portofolio tidak valid.',
            'judul_kegiatan.required' => 'Judul kegiatan harus diisi.',
            'penyelenggara.required' => 'Penyelenggara harus diisi.',
            'deskripsi_kegiatan.required' => 'Deskripsi kegiatan harus diisi.',
            'link_sertifikat.required' => 'Link sertifikat harus diisi.',
            'link_sertifikat.url' => 'Link sertifikat harus berupa URL yang valid.',
        ];
    }
}