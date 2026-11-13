@if ($paginator->hasPages())
    <nav class="font-sans" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="flex items-center justify-between gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex cursor-not-allowed items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-zinc-500 rounded-none">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-black rounded-none transition hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-black active:bg-zinc-200">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-black rounded-none transition hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-black active:bg-zinc-200">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex cursor-not-allowed items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-zinc-500 rounded-none">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>
    </nav>
@endif