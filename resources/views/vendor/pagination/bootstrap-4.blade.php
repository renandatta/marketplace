@if ($paginator->hasPages())
    <div class="products-view__pagination">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link page-link--with-arrow" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <i class="fa fa-angle-left page-link__arrow page-link__arrow--left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link">{{ $page }} <span class="sr-only">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link page-link--with-arrow" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <i class="fa fa-angle-right page-link__arrow page-link__arrow--right"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
