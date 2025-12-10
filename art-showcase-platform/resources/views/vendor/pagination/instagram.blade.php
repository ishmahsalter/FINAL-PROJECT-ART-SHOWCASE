<!-- resources/views/vendor/pagination/instagram.blade.php -->
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2.5 bg-purple-900/30 border border-purple-500/30 text-purple-400 rounded-xl cursor-not-allowed">
                &laquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-4 py-2.5 bg-purple-900/30 border border-purple-500/30 text-white hover:bg-purple-800/50 hover:border-yellow-400/50 rounded-xl transition-all duration-300">
                &laquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2.5 text-purple-300">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-5 py-2.5 bg-gradient-to-r from-yellow-400 to-orange-500 text-white font-bold rounded-xl shadow-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-5 py-2.5 bg-purple-900/30 border border-purple-500/30 text-white hover:bg-purple-800/50 hover:border-yellow-400/50 rounded-xl transition-all duration-300">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-4 py-2.5 bg-purple-900/30 border border-purple-500/30 text-white hover:bg-purple-800/50 hover:border-yellow-400/50 rounded-xl transition-all duration-300">
                &raquo;
            </a>
        @else
            <span class="px-4 py-2.5 bg-purple-900/30 border border-purple-500/30 text-purple-400 rounded-xl cursor-not-allowed">
                &raquo;
            </span>
        @endif
    </nav>
@endif