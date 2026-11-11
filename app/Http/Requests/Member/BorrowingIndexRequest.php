<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BorrowingIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', Rule::in(['requested', 'approved', 'rejected', 'returned', 'cancelled'])],
        ];
    }
}
