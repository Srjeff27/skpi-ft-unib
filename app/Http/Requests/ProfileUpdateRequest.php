<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nim' => ['nullable', 'string', 'max:255', Rule::unique(User::class, 'nim')->ignore($this->user()->id)],
            'angkatan' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'prodi_id' => ['nullable', 'exists:prodis,id'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            // New profile fields
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            // Graduation data (admin only)
            'tanggal_lulus' => [
                Rule::prohibitedIf(auth()->user()->role !== 'admin'),
                'nullable', 
                'date'
            ],
            'nomor_ijazah' => [
                Rule::prohibitedIf(auth()->user()->role !== 'admin'),
                'nullable', 
                'string', 
                'max:255'
            ],
            'nomor_skpi' => [
                Rule::prohibitedIf(auth()->user()->role !== 'admin'),
                'nullable', 
                'string', 
                'max:255'
            ],
            'gelar_id' => [
                Rule::prohibitedIf(auth()->user()->role !== 'admin'),
                'nullable', 
                'string', 
                'max:255'
            ],
            'gelar_en' => [
                Rule::prohibitedIf(auth()->user()->role !== 'admin'),
                'nullable', 
                'string', 
                'max:255'
            ],
        ];
    }
}
