<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BorrowingIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', Rule::in(['requested', 'approved', 'returned', 'rejected', 'cancelled', 'ditolak', 'terlambat', 'semua'])],
            'q' => ['nullable', 'string', 'max:120'],
        ];
    }
}
