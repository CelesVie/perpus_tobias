<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RejectBorrowingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reject_reason' => ['required', 'string', 'max:255'],
        ];
    }
}
