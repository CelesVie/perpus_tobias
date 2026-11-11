<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PublisherRequest;
use App\Models\Publisher;
use App\Services\CatalogMetadataService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function index(): View
    {
        return view('admin.publishers.index', [
            'publishers' => Publisher::query()->withCount('books')->orderBy('name')->paginate(15),
        ]);
    }

    public function store(PublisherRequest $request, CatalogMetadataService $metadata): RedirectResponse
    {
        $metadata->createPublisher($request->validated());

        return back()->with('status', 'Penerbit ditambahkan.');
    }

    public function update(PublisherRequest $request, Publisher $publisher, CatalogMetadataService $metadata): RedirectResponse
    {
        $metadata->updatePublisher($publisher, $request->validated());

        return back()->with('status', 'Data penerbit diperbarui.');
    }

    public function destroy(Publisher $publisher, CatalogMetadataService $metadata): RedirectResponse
    {
        try {
            $metadata->deletePublisher($publisher);
        } catch (ValidationException $exception) {
            return back()->with('error', $exception->validator->errors()->first());
        }

        return back()->with('status', 'Penerbit dihapus.');
    }
}
