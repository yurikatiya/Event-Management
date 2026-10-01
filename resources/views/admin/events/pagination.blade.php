@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-center gap-1.5">
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" aria-label="Previous page" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-blue-200">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page" title="Previous page" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sky-700 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-sky-200">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span aria-disabled="true" class="px-2 text-sm text-slate-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-sky-600 px-3 text-sm font-semibold text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Go to page {{ $page }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full px-3 text-sm font-medium text-slate-600 transition hover:bg-blue-100 hover:text-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page" title="Next page" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-sky-700 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-sky-200">
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        @else
            <span aria-disabled="true" aria-label="Next page" class="inline-flex h-9 w-9 items-center justify-center rounded-full text-blue-200">
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </span>
        @endif
    </nav>
@endif