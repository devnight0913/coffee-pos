<x-table>
    <x-thead>
        <tr>
            <x-th>@lang('Invoice Number')</x-th>
            <x-th>@lang('Customer')</x-th>
            <x-th>@lang('Discount')</x-th>
            <x-th>@lang('Delivery Charge')</x-th>
            <x-th>@lang('Subtotal')</x-th>
            <x-th>@lang('Total')</x-th>
            <x-th>@lang('Paid')</x-th>
            <x-th>@lang('Owe')</x-th>
            <x-th>@lang('Date')</x-th>
            <x-th>@lang('Author')</x-th>
            <x-th></x-th>
        </tr>
    </x-thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <x-td class="align-middle fw-bold">
                    <a href="{{ route('orders.show', $order) }}" class="text-decoration-none">
                        {{ $order->number }}

                    </a>
                </x-td>
                <x-td class="align-middle fw-bold">
                    @if ($order->has_customer)
                        <a href="{{ route('customers.show', $order->customer) }}" class="text-decoration-none">
                            {{ $order->customer_name }}
                        </a>
                    @else
                        -
                    @endif
                </x-td>
                <x-td class="align-middle">
                    {{ $order->discount_view }}
                </x-td>
                <x-td class="align-middle">
                    {{ $order->delivery_charge_view }}
                </x-td>
                <x-td class="align-middle">
                    {{ $order->subtotal_view }}
                </x-td>
                <x-td class="align-middle">
                    {{ $order->total_view }}
                </x-td>
                <x-td class="align-middle">
                    {{ $order->tender_amount_view }}
                </x-td>
                <x-td class="align-middle">
                    {{ $order->owe_view }}
                </x-td>
                <x-td class="align-middle text-start" lang="en" dir="auto">
                    {{ $order->created_at_view }}
                </x-td>
                <x-td class="align-middle text-start" lang="en" dir="auto">
                    {{ $order->author_name }}
                </x-td>
                <x-td class="align-middle">
                    <div class="dropdown d-flex">
                        <button class="btn btn-link ms-auto text-black p-0" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" data-bs-boundary="window" aria-expanded="false">
                            <x-heroicon-o-ellipsis-horizontal class="hero-icon" />
                        </button>
                        <x-dropdown-menu class="dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            @can_edit
                            <x-dropdown-item href="{{ route('orders.show', $order) }}">
                                <x-heroicon-o-eye class="hero-icon-sm me-2 text-gray-400" /> @lang('View')
                            </x-dropdown-item>
                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>
                            @endcan_edit
                            @can_edit

                            <x-dropdown-item href="{{ route('orders.edit', $order) }}">
                                <x-heroicon-o-pencil class="hero-icon-sm me-2 text-gray-400" /> @lang('Edit')
                            </x-dropdown-item>

                            @endcan_edit
                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>

                            <x-dropdown-item href="{{ route('orders.print', $order) }}" target="_blank">
                                <x-heroicon-o-printer class="hero-icon-sm me-2 text-gray-400" /> @lang('Print Receipt')
                            </x-dropdown-item>

                            <li>
                                <hr class="dropdown-divider m-0">
                            </li>

                            @can_delete
                            <x-dropdown-item href="#">
                                <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                    id="form-{{ $order->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="btn btn-sm btn-link p-0 m-0 w-100 text-start text-decoration-none text-danger d-flex align-items-center"
                                        onclick="submitDeleteForm('{{ $order->id }}')">
                                        <x-heroicon-o-trash class="hero-icon-sm me-2 text-gray-400" />
                                        @lang('Delete')
                                    </button>
                                </form>
                            </x-dropdown-item>
                            @endcan_delete
                        </x-dropdown-menu>
                    </div>
                </x-td>
            </tr>
        @endforeach
    </tbody>
</x-table>
@if ($orders->isEmpty())
    <x-no-data />
@endif

@can_delete
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
@endcan_delete
