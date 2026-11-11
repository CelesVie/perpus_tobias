<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BorrowingIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', Rule::in(['requested', 'approved', 'rejected', 'returned', 'cancelled', 'semua', 'terlambat'])],
            'q' => ['nullable', 'string', 'max:120'],
        ];
    }
}
