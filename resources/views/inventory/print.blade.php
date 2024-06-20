<html lang="en" dir="ltr">

<head>
    <title>@lang('Inventory Report')</title>
</head>

<body>
    <div style="font-size: 1.50rem;font-weight: 700;margin-bottom: 1rem">{{ $storeName }}</div>

    <div style="font-weight: 700;margin-bottom: 1.5rem">@lang('Inventory Report')</div>
    <div>{{ $inventoryHistory->start_date }} -</div>
    <div>{{ $inventoryHistory->end_date }}</div>

    <hr style="font-weight: 700;margin-bottom: 1.5rem">

    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Invoices')</div>
        <div style="margin-left: auto">{{ $inventoryHistory->invoices }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Customers')</div>
        <div style="margin-left: auto">{{ $inventoryHistory->customers }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Cash Sales')</div>
        <div style="margin-left: auto">{{ currency_format($inventoryHistory->cash_sales) }}</div>
    </div>
    <hr style="font-weight: 700;margin-bottom: 1.5rem">
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
