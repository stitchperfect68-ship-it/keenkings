@if ($paginator->hasPages())
<nav class="pagination-nav">
    @if ($paginator->onFirstPage())
        <span class="page-btn disabled"><i data-feather="chevron-left"></i></span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="page-btn"><i data-feather="chevron-left"></i></a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="page-btn disabled">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="page-btn"><i data-feather="chevron-right"></i></a>
    @else
        <span class="page-btn disabled"><i data-feather="chevron-right"></i></span>
    @endif
</nav>
@endif
