<button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#filterModal">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="hero-icon-sm me-1">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
    </svg>
    @lang('Filter')
</button>
<div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">@lang('Account Statement Filter')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customers.statements.filter', $customer) }}" method="GET" role="form">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">@lang('From Date')</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">@lang('To Date')</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">@lang('Use Filter')</button>
                </div>
            </form>
        </div>
    </div>
</div>
