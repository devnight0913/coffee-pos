<div class="modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="filterModalLabel">
                    <i class="bi bi-funnel-fill align-middle fs-5"></i> @lang('Search Filter')
                </h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.filter') }}" role="form" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="date-from" class="form-label">@lang('Start Date')</label>
                        <input type="date" name="from" class="form-control" id="date-from"
                            value="{{ Request::get('from') }}">
                    </div>
                    <div class="mb-3">
                        <label for="date-to" class="form-label">@lang('End Date')</label>
                        <input type="date" name="to" class="form-control" id="date-to"
                            value="{{ Request::get('to') }}">
                    </div>
                    <div class="mb-3">
                        <label for="customer-name" class="form-label">@lang('Customer Name') <small
                                class="text-muted fw-normal">@lang('optional')</small></label>
                        <input type="text" name="name" class="form-control" id="customer-name"
                            value="{{ Request::get('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">@lang('Author') <small
                                class="text-muted fw-normal">@lang('optional')</small></label>
                        <select name="author" id="author" class=" form-select">
                            <option value=""></option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @selected(Request::get('author') == $author->id)>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">@lang('Use Filter')</button>
                </div>
            </form>
        </div>
    </div>
</div>
