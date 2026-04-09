@if ($paginator->hasPages())
<div class="flex items-center justify-center gap-3 mt-10">

    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span class="text-brand-dark/25 font-bold text-lg select-none px-1">&lt;</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="text-brand-dark/40 hover:text-brand-dark font-bold text-lg px-1 transition-colors duration-150">
            &lt;
        </a>
    @endif

    {{-- Dots --}}
    @foreach ($elements as $element)
        {{-- Separator "..." --}}
        @if (is_string($element))
            <span class="w-3 h-3 rounded-full bg-brand-dark/15 inline-block"></span>
        @endif

        {{-- Page links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    {{-- Active dot — purple --}}
                    <span class="w-3 h-3 rounded-full bg-brand-purple inline-block
                                 ring-2 ring-brand-purple/30 ring-offset-1"></span>
                @else
                    {{-- Inactive dot — green --}}
                    <a href="{{ $url }}"
                       class="w-3 h-3 rounded-full bg-brand-green inline-block
                              hover:opacity-70 transition-opacity duration-150">
                    </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="text-brand-dark/40 hover:text-brand-dark font-bold text-lg px-1 transition-colors duration-150">
            &gt;
        </a>
    @else
        <span class="text-brand-dark/25 font-bold text-lg select-none px-1">&gt;</span>
    @endif

</div>
@endif