<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorRequest extends FormRequest
{
    public function rules(): array
    {
        $author = $this->route('author');

        return [
            'name' => ['required', 'string', 'max:120', Rule::unique('authors', 'name')->ignore($author?->id)],
            'bio' => ['nullable', 'string', 'max:255'],
        ];
    }
}
