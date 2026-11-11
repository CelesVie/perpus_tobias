<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'library_name' => ['required', 'string', 'max:80'],
            'library_tagline' => ['nullable', 'string', 'max:120'],
            'library_address' => ['nullable', 'string', 'max:160'],
            'library_phone' => ['nullable', 'string', 'max:30'],
            'library_email' => ['nullable', 'email', 'max:120'],
            'loan_duration_days' => ['required', 'integer', 'min:1', 'max:90'],
            'max_active_loans' => ['required', 'integer', 'min:1', 'max:10'],
            'fine_per_day' => ['required', 'integer', 'min:0', 'max:100000'],
            'max_fine_days' => ['required', 'integer', 'min:1', 'max:365'],
        ];
    }
}
