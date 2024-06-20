<x-card class="mb-3">
    <div class="card-title">@lang('Cost in the last 12 months')</div>
    <div class="mb-3 fw-bold h4">{{ currency_format($totalCostMonth->sum('total')) }}</div>
    <canvas id="total-cost-chart"></canvas>
</x-card>

@push('script')
    <script type="text/javascript">
        var cost_chart_element = document.getElementById("total-cost-chart").getContext("2d");
        orders_chart = new Chart(cost_chart_element, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "{{ __('Cost') }}",
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
                    text: "Total Cost Per Month"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Total Cost Per Month"
                        }
                    }],
                    xAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Data"
                        }
                    }]
                }
            }
        });
        @foreach ($totalCostMonth as $order)
            orders_chart.data.labels.push("{{ $order->date }}"), orders_chart.data.datasets.forEach(a => {
                a.data.push("{{ $order->total }}");
            });
        @endforeach
        orders_chart.update();
    </script>
@endpush
