@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        {{-- Previous Button (Mobile) --}}
        @if ($paginator->onFirstPage())
        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-brand-medium bg-brand-lightest border border-brand-light cursor-default leading-5 rounded-md dark:text-brand-medium dark:bg-brand-dark dark:border-brand-dark">
            {!! __('pagination.previous') !!}
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-brand-darkest bg-brand-lightest border border-brand-light leading-5 rounded-md hover:text-brand-dark focus:outline-none focus:ring ring-brand-medium focus:border-brand-dark active:bg-brand-light active:text-brand-darkest transition ease-in-out duration-150 dark:bg-brand-dark dark:border-brand-dark dark:text-brand-lightest dark:focus:border-brand-medium dark:active:bg-brand-darkest dark:active:text-brand-lightest">
            {!! __('pagination.previous') !!}
        </a>
        @endif

        {{-- Next Button (Mobile) --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-brand-darkest bg-brand-lightest border border-brand-light leading-5 rounded-md hover:text-brand-dark focus:outline-none focus:ring ring-brand-medium focus:border-brand-dark active:bg-brand-light active:text-brand-darkest transition ease-in-out duration-150 dark:bg-brand-dark dark:border-brand-dark dark:text-brand-lightest dark:focus:border-brand-medium dark:active:bg-brand-darkest dark:active:text-brand-lightest">
            {!! __('pagination.next') !!}
        </a>
        @else
        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-brand-medium bg-brand-lightest border border-brand-light cursor-default leading-5 rounded-md dark:text-brand-medium dark:bg-brand-dark dark:border-brand-dark">
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        {{-- Showing Results Text (Desktop) --}}
        <div>
            <p class="text-sm text-brand-darkest leading-5 dark:text-brand-light">
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
        </div>

        <div>
            <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                {{-- Previous Page Link (Desktop) --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-brand-medium bg-brand-lightest border border-brand-light cursor-default rounded-l-md leading-5 dark:bg-brand-dark dark:border-brand-dark" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-brand-dark bg-brand-lightest border border-brand-light rounded-l-md leading-5 hover:text-brand-darkest focus:z-10 focus:outline-none focus:ring ring-brand-medium focus:border-brand-dark active:bg-brand-light active:text-brand-darkest transition ease-in-out duration-150 dark:bg-brand-dark dark:border-brand-dark dark:active:bg-brand-darkest dark:focus:border-brand-medium" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                {{-- Pagination Elements (Page Numbers) --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-brand-dark bg-brand-lightest border border-brand-light cursor-default leading-5 dark:bg-brand-dark dark:border-brand-dark">{{ $element }}</span>
                </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-brand-lightest bg-brand-darkest border border-brand-darkest cursor-default leading-5 dark:bg-brand-darkest dark:border-brand-darkest">{{ $page }}</span>
                </span>
                @else
                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-brand-dark bg-brand-lightest border border-brand-light leading-5 hover:text-brand-darkest focus:z-10 focus:outline-none focus:ring ring-brand-medium focus:border-brand-dark active:bg-brand-light active:text-brand-darkest transition ease-in-out duration-150 dark:bg-brand-dark dark:border-brand-dark dark:text-brand-light dark:hover:text-brand-lightest dark:active:bg-brand-darkest dark:focus:border-brand-medium" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link (Desktop) --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-brand-dark bg-brand-lightest border border-brand-light rounded-r-md leading-5 hover:text-brand-darkest focus:z-10 focus:outline-none focus:ring ring-brand-medium focus:border-brand-dark active:bg-brand-light active:text-brand-darkest transition ease-in-out duration-150 dark:bg-brand-dark dark:border-brand-dark dark:active:bg-brand-darkest dark:focus:border-brand-medium" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-brand-medium bg-brand-lightest border border-brand-light cursor-default rounded-r-md leading-5 dark:bg-brand-dark dark:border-brand-dark" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif