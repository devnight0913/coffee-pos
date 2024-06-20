<x-card class="mb-3">
    <div class="card-title">{{ $cardTitle }}</div>
    <div class="mb-3 fw-bold h4">{{ $totalOrdersPerMonth->sum('total') }}</div>
    <canvas id="total-orders-chart"></canvas>
</x-card>
@push('script')
    <script type="text/javascript">
        var orders_chart_element = document.getElementById("total-orders-chart").getContext("2d");
        orders_chart = new Chart(orders_chart_element, {
            type: "line",
            data: {
                labels: [],
                datasets: [{
                    label: "{{ __('Invoices') }}",
                    borderColor: "#1A73E8",
                    borderWidth: 3,
                    lineTension: 0.05,
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
                    text: "Total Orders Per Month"
                },
                scales: {
                    yAxes: [{
                        scaleLabel: {
                            display: !0,
                            labelString: "Total Orders Per Month"
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
        @foreach ($totalOrdersPerMonth as $order)
            orders_chart.data.labels.push("{{ $order->date }}"), orders_chart.data.datasets.forEach(a => {
                a.data.push("{{ $order->total }}");
            });
        @endforeach
        orders_chart.update();
    </script>
@endpush
