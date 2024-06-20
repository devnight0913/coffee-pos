<div class="d-flex align-items-center mb-5">
    <div class="flex-grow-1">
       <div class="flex-grow-1 h1 fw-bold mb-0">
            {{ $settings->storeName }}
        </div>
    </div>
    <div>
        @if ($settings->storeAddress)
            <div> {{ $settings->storeAddress }}</div>
        @endif
        @if ($settings->storePhone)
            <div> {{ $settings->storePhone }}</div>
        @endif
        @if ($settings->storeWebsite)
            <div> {{ $settings->storeWebsite }}</div>
        @endif
        @if ($settings->storeEmail)
            <div> {{ $settings->storeEmail }}</div>
        @endif
    </div>
</div>
<div class="mb-3 text-uppercase text-center fw-bold h4">QUOTATION #{{ $order->number }}</div>
<table class="table table-bordered mb-3">
    <tbody>
        <tr>
            <td>QUOTATION №</td>
            <td>{{ $order->number }}</td>
        </tr>
        <tr>
            <td>DATE</td>
            <td>{{ $order->date_view }}</td>
        </tr>
        <tr>
            <td>TIME</td>
            <td>{{ $order->time_view }}</td>
        </tr>
        @if ($order->has_customer)
            <tr>
                <td>TO</td>
                <td>
                    <div>{{ $order->customer->name }}</div>
                    @if ($order->customer->mobile)
                        <div class="text-muted small"> {{ $order->customer->mobile }}</div>
                    @endif
                    @if ($order->customer->telephone)
                        <div class="text-muted small"> {{ $order->customer->telephone }}</div>
                    @endif
                    <div class="text-muted small"> {{ $order->customer->print_address }}</div>
                </td>
            </tr>
        @endif
        @if ($order->remarks)
            <tr>
                <td>REMARKS</td>
                <td>{{ $order->remarks }}</td>
            </tr>
        @endif
    </tbody>
</table>
