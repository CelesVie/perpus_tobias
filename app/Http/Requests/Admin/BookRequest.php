<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $book = $this->route('book');

        return [
            'title' => ['required', 'string', 'max:180'],
            'isbn' => ['nullable', 'string', 'max:20', Rule::unique('books', 'isbn')->ignore($book?->id)],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'publisher_id' => ['nullable', 'integer', 'exists:publishers,id'],
            'author_ids' => ['required', 'array', 'min:1'],
            'author_ids.*' => ['integer', 'exists:authors,id'],
            'publication_year' => ['nullable', 'integer', 'min:1800', 'max:'.(now()->year + 1)],
            'page_count' => ['nullable', 'integer', 'min:1', 'max:5000'],
            'description' => ['nullable', 'string', 'max:2000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'total_copies' => ['required', 'integer', 'min:1', 'max:999'],
            'is_featured' => ['boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'judul',
            'isbn' => 'ISBN',
            'category_id' => 'kategori',
            'publisher_id' => 'penerbit',
            'author_ids' => 'penulis',
            'publication_year' => 'tahun terbit',
            'page_count' => 'jumlah halaman',
            'description' => 'deskripsi',
            'cover' => 'sampul',
            'total_copies' => 'jumlah eksemplar',
        ];
    }
}
