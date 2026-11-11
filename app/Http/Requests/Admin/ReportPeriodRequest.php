<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportPeriodRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'periode' => ['nullable', 'string', Rule::in(['minggu-ini', 'bulan-ini', 'bulan-lalu', 'tahun-ini'])],
        ];
    }
}
