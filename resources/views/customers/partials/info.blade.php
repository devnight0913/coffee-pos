<div class="d-flex align-items-center justify-content-center mb-3">
    <div class="mb-0">
        <a href="{{ route('customers.show', $customer) }}" class="text-body text-decoration-none">
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <svg width="50" height="50" viewBox="0 0 50 50"
                        class="text-primary-500 w-10 h-10 xl:w-12 xl:h-12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="25" cy="25" r="25" fill="#EAF1FB"></circle>
                        <path
                            d="M28.2656 23.0547C27.3021 24.0182 26.1302 24.5 24.75 24.5C23.3698 24.5 22.1849 24.0182 21.1953 23.0547C20.2318 22.0651 19.75 20.8802 19.75 19.5C19.75 18.1198 20.2318 16.9479 21.1953 15.9844C22.1849 14.9948 23.3698 14.5 24.75 14.5C26.1302 14.5 27.3021 14.9948 28.2656 15.9844C29.2552 16.9479 29.75 18.1198 29.75 19.5C29.75 20.8802 29.2552 22.0651 28.2656 23.0547ZM28.2656 25.75C29.6979 25.75 30.9219 26.2708 31.9375 27.3125C32.9792 28.3281 33.5 29.5521 33.5 30.9844V32.625C33.5 33.1458 33.3177 33.5885 32.9531 33.9531C32.5885 34.3177 32.1458 34.5 31.625 34.5H17.875C17.3542 34.5 16.9115 34.3177 16.5469 33.9531C16.1823 33.5885 16 33.1458 16 32.625V30.9844C16 29.5521 16.5078 28.3281 17.5234 27.3125C18.5651 26.2708 19.8021 25.75 21.2344 25.75H21.8984C22.8099 26.1667 23.7604 26.375 24.75 26.375C25.7396 26.375 26.6901 26.1667 27.6016 25.75H28.2656Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
                <div>
                    <div class="fs-5 fw-bold">{{ $customer->name }}</div>
                    <div class="small">{{ $customer->number }}</div>
                </div>
            </div>

        </a>
    </div>
    <div class="dropdown ms-auto">
        <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hero-icon">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>

        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item" href="{{ route('customers.show', $customer) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    @lang('View')
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="{{ route('customers.statements.index', $customer) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    @lang('Account Statement')
                </a>
            </li>


            <li>
                <a class="dropdown-item" href="{{ route('customers.orders.index', $customer) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 3.75H6.912a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859M12 3v8.25m0 0l-3-3m3 3l3-3" />
                    </svg>
                    @lang('Invoices')
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('customers.payments.index', $customer) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @lang('Payments')
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('customers.payments.create', $customer) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @lang('Create Payment')
                </a>
            </li>
            @can_edit
            <li>
                <a class="dropdown-item" href="{{ route('customers.edit', $customer) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="hero-icon-sm me-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    @lang('Edit')
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="#">
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                        id="form-{{ $customer->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            class="btn btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger"
                            onclick="submitDeleteForm('{{ $customer->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="hero-icon-sm me-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                            @lang('Delete')
                        </button>
                    </form>
                </a>
            </li>
            @endcan_edit
        </ul>
    </div>
</div>


@push('script')
    <script>
        function submitDeleteForm(id) {
            const form = document.querySelector(`#form-${id}`);
            Swal.fire(swalConfig()).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    topbar.hide();
                }
            });
        }
    </script>
@endpush
