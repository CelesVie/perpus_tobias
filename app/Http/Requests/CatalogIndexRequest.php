<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CatalogIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:80'],
            'kategori' => ['nullable', 'string', 'max:80'],
            'penulis' => ['nullable', 'integer', 'exists:authors,id'],
            'penerbit' => ['nullable', 'integer', 'exists:publishers,id'],
            'tahun' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'ketersediaan' => ['nullable', Rule::in(['tersedia', 'dipinjam'])],
            'urut' => ['nullable', Rule::in(['', 'baru', 'populer', 'judul'])],
        ];
    }
}
