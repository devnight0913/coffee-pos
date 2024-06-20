@props(['action' => '#'])
<form action="{{ $action }}" role="form">
    <div class="position-relative">
        <input type="search" name="search_query" value="{{ Request::get('search_query') }}" class="form-control w-auto form-control-search"
            placeholder="@lang('Search...')" autocomplete="off">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="position-absolute top-50 start-0 translate-middle-y text-muted search-icon">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
    </div>
</form>
