{{-- <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header">
        <h1 class="offcanvas-title text-king" id="offcanvasSidebarLabel">
            {{ $appStoreName }}
        </h1>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush py-2">
            @foreach ($items as $item)
                <a class="list-group-item list-group-item-action sidebar-item align-items-center d-flex py-3
                @if ($item['active']) text-primary fw-bold @endif"
                    href="{{ $item['route'] }}" @if ($item['is_blank']) target="_blank" @endif>
                    {!! $item['icon'] !!}{{ $item['name'] }}
                </a>
            @endforeach
        </div>
    </div>
</div> --}}
<div class="list-group list-group-flush border-top">
    @foreach ($items as $item)
        @if (!$item['disabled'])
            <a class="list-group-item list-group-item-action sidebar-item align-items-center d-flex py-3 px-0 ps-4 border-0 
             border-start border-4 font-medium small
            @if ($item['active']) text-primary bg-body border-primary @else border-white text-black @endif  
            @if ($item['disabled']) cursor-not-allowed @endif"
                href="{{ $item['route'] }}" @if ($item['is_blank']) target="_blank" @endif>
                {!! $item['icon'] !!}{{ $item['name'] }}
            </a>
        @endif
    @endforeach
</div>
