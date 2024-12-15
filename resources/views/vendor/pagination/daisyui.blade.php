@if ($paginator->hasPages())
  <nav
    role="navigation"
    aria-label="Pagination Navigation"
    class="flex justify-center"
  >
    <ul class="pagination flex justify-between gap-2">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li
          class="disabled"
          aria-disabled="true"
          aria-label="@lang('pagination.previous')"
        >
          <span class="btn btn-disabled" aria-hidden="true">&laquo;</span>
        </li>
      @else
        <li>
          <a
            href="{{ $paginator->previousPageUrl() }}"
            rel="prev"
            class="btn"
            aria-label="@lang('pagination.previous')"
          >
            &laquo;
          </a>
        </li>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
          <li class="disabled" aria-disabled="true">
            <span class="btn btn-disabled">{{ $element }}</span>
          </li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <li class="active" aria-current="page">
                <span class="btn btn-active">{{ $page }}</span>
              </li>
            @else
              <li><a href="{{ $url }}" class="btn">{{ $page }}</a></li>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li>
          <a
            href="{{ $paginator->nextPageUrl() }}"
            rel="next"
            class="btn"
            aria-label="@lang('pagination.next')"
          >
            &raquo;
          </a>
        </li>
      @else
        <li
          class="disabled"
          aria-disabled="true"
          aria-label="@lang('pagination.next')"
        >
          <span class="btn btn-disabled" aria-hidden="true">&raquo;</span>
        </li>
      @endif
    </ul>
  </nav>
@endif
