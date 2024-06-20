<html lang="ar" dir="rtl">

<head>
    <title>@lang('Drawer Report')</title>
</head>

<body>
    <div style="font-size: 1.50rem;font-weight: 700;margin-bottom: 1rem">{{ $storeName }}</div>
    <div style="font-weight: 700;margin-bottom: 1.5rem">@lang('Drawer Report')</div>
    <div>{{ $drawerHistory->start_date }} -</div>
    <div>{{ $drawerHistory->end_date }}</div>

    <hr style="font-weight: 700;margin-bottom: 1.5rem">

    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Starting Cash')</div>
        <div style="margin-right: auto">{{ currency_format($drawerHistory->starting_cash) }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Cash Sales')</div>
        <div style="margin-right: auto">{{ currency_format($drawerHistory->cash_sales) }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Payouts')</div>
        <div style="margin-right: auto">{{ currency_format($drawerHistory->paid_out) }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem;font-weight: 700">
        <div>@lang('Expected in drawer')</div>
        <div style="margin-right: auto">{{ currency_format($drawerHistory->expected) }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Actual in drawer')</div>
        <div style="margin-right: auto">{{ currency_format($drawerHistory->actual) }}</div>
    </div>
    <div style="display: flex;margin-bottom: 1.5rem">
        <div>@lang('Difference')</div>
        <div style="margin-right: auto" dir="ltr">{{ $drawerHistory->difference_view }}</div>
    </div>
    <hr style="font-weight: 700;margin-bottom: 1.5rem">
</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.print();
    });
</script>
