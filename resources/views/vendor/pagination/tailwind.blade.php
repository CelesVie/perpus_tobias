@if ($paginator->hasPages())
    <nav class="font-sans" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="flex items-center justify-between gap-2 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-zinc-500 rounded-none cursor-not-allowed">
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
                <span class="inline-flex items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-zinc-500 rounded-none cursor-not-allowed">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between sm:gap-2">
            <p class="text-xs leading-5 text-zinc-700">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>

            <div>
                <span class="inline-flex rtl:flex-row-reverse">
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center border border-black bg-white px-2 py-2 text-sm font-medium leading-5 text-zinc-500 rounded-none cursor-not-allowed" aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center border border-black bg-white px-2 py-2 text-sm font-medium leading-5 text-black rounded-none transition hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-black active:bg-zinc-200" aria-label="{{ __('pagination.previous') }}">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="-ml-px inline-flex cursor-default items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-black rounded-none">{{ $element }}</span>
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="-ml-px inline-flex cursor-default items-center border border-black bg-black px-4 py-2 text-sm font-medium leading-5 text-white rounded-none">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="-ml-px inline-flex items-center border border-black bg-white px-4 py-2 text-sm font-medium leading-5 text-black rounded-none transition hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-black active:bg-zinc-200" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="-ml-px inline-flex items-center border border-black bg-white px-2 py-2 text-sm font-medium leading-5 text-black rounded-none transition hover:bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-black active:bg-zinc-200" aria-label="{{ __('pagination.next') }}">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="-ml-px inline-flex items-center border border-black bg-white px-2 py-2 text-sm font-medium leading-5 text-zinc-500 rounded-none cursor-not-allowed" aria-hidden="true">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
