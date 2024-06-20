<x-card class="mb-3">
    <div class="card-title">@lang('Profit in the last 12 months')</div>
    <div class="mb-3 fw-bold h4">{{ currency_format($totalProfitMonth->sum('total')) }}</div>
    <canvas id="total-profit-chart"></canvas>
</x-card>

@push('script')
    <script type="text/javascript">
        var profit_chart_element = document.getElementById("total-profit-chart").getContext("2d");
        orders_chart = new Chart(profit_chart_element, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "{{ __('Profit') }}",
                    backgroundColor: ["#1A73E8"],
                    data: []
                }]
            },
            options: {
                layout: {
                    padding: 10
                },
                legend: {
                    position: "bottom"
                },
                title: {
                    display: !0,
                    text: "Total Profit Per Month"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Total Profit Per Month"
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "{{ __('Date') }}"
                        }
                    }]
                }
            }
        });
        @for ($i = 0; $i < $totalProfitMonth->count(); $i++)
            orders_chart.data.labels.push("{{ $totalProfitMonth[$i]->date }}"), orders_chart.data.datasets.forEach(a => {
                a.data.push("{{ $totalProfitMonth[$i]->total - $totalDiscountPerMonth[$i]->sum('discount') }}");
            });
        @endfor
        orders_chart.update();
    </script>
@endpush
