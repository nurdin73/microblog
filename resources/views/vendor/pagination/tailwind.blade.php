@if ($paginator->hasPages())
<nav aria-label="Table navigation">
    <ul class="inline-flex items-center">
        @if ($paginator->onFirstPage())
            <li>
                <button disabled type="button" class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-green" aria-label="Previous">
                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}&search={{ request()->search }}&limit={{ request()->limit }}" class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-green" aria-label="Previous">
                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li>
                    <span class="px-3 py-1">...</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <button class="px-3 py-1 text-white transition-colors duration-150 bg-green-700 border border-r-0 border-green-700 rounded-md focus:outline-none focus:shadow-outline-green">{{ $page }}</button>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}&search={{ request()->search }}&limit={{ request()->limit }}" class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-green">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        

        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}&search={{ request()->search }}&limit={{ request()->limit }}" class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-green" aria-label="Next">
                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </a>
            </li>
        @else
            <li>
                <button type="button" disabled class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-green" aria-label="Next">
                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                        <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" fill-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
        @endif
    </ul>
</nav>
@endif
