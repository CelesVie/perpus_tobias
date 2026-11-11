<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingsRequest;
use App\Models\Setting;
use App\Services\LibrarySettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', [
            'values' => collect(Setting::DEFAULTS)->mapWithKeys(
                fn (string $default, string $key): array => [$key => Setting::get($key, $default)]
            ),
        ]);
    }

    public function update(SettingsRequest $request, LibrarySettingsService $settings): RedirectResponse
    {
        $settings->update($request->validated());

        return back()->with('status', 'Pengaturan disimpan.');
    }
}
