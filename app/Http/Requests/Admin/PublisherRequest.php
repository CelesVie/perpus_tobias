<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublisherRequest extends FormRequest
{
    public function rules(): array
    {
        $publisher = $this->route('publisher');

        return [
            'name' => ['required', 'string', 'max:120', Rule::unique('publishers', 'name')->ignore($publisher?->id)],
            'city' => ['nullable', 'string', 'max:80'],
        ];
    }
}
